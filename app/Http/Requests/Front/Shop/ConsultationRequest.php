<?php

namespace App\Http\Requests\Front\Shop;

use App\Models\Catalog\Discipline;
use App\Models\Catalog\Duration;
use App\Models\Shop\Consultation;
use App\Models\User\Expert;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'duration_id' => 'required|exists:durations,id',
        ];
    }

    /**
     * Handle request.
     *
     * @param Consultation $consultation
     * @param Discipline $discipline
     * @param array $data
     * @return Consultation|null
     * @throws \Exception
     */
    public function handle(Consultation $consultation, Discipline $discipline, array $data = array()): ?Consultation
    {
        $data = array_merge($this->validated(), $data);

        /** @var Duration $duration */
        $duration = Duration::findOrFail($data['duration_id']);

        /** @var Expert $expert */
        $expert = Expert::findOrFail($consultation->expert_id);

        $app_timezone = config('app.timezone');
        $user_timezone = $this->get('timezone');
        $start = Carbon::parse($data['date'], $user_timezone)->setSecond(0)->setMillisecond(0)->timezone($app_timezone);
        $end = $start->copy()->add($duration->delay);

        $builder = $expert->rooms();
        $builder->where(function (Builder $builder) use ($start, $end) {
            /* 1-a-b-2 */
            $builder->orWhere(function (Builder $builder) use ($start, $end) {
                $builder->where('rooms.start_at', '<=', $start); // 00:00
                $builder->where('rooms.end_at', '>=', $end); // 15:00
            });
            /* a-1-2-b */
            $builder->orWhere(function (Builder $builder) use ($start, $end) {
                $builder->where('rooms.start_at', '>=', $start); // 00:00
                $builder->where('rooms.end_at', '<=', $end); // 15:00
            });
            /* 1-a-2-b */
            $builder->orWhere(function (Builder $builder) use ($start) {
                $builder->where('rooms.start_at', '<', $start); // 00:00
                $builder->where('rooms.end_at', '>', $start); // 00:00
            });
            /* a-1-b-2 */
            $builder->orWhere(function (Builder $builder) use ($end) {
                $builder->where('rooms.start_at', '<', $end); // 15:00
                $builder->where('rooms.end_at', '>', $end); // 15:00
            });
        });
        $exists = $builder->exists();
        if($exists){
            throw new \Exception('Votre consultant n’est pas disponible pour pour cette durée. Veuillez essayer un autre créneau.');
        }

        $builder = $expert->timeSlots();
        if($start->isSameDay($end)){
            $weekday = $start->weekday();
            $builder->whereRaw('time_slots.weekday = ?', $weekday);
            $builder->whereRaw('DATE_FORMAT(time_slots.start_at, "%H:%i") <= ?', $start->format('H:i'));
            $builder->where(function (Builder $builder) use ($end) {
                // 00:00:00
                $builder->orWhereRaw('DATE_FORMAT(DATE_SUB(CONCAT(CURDATE(), " ", time_slots.end_at), INTERVAL 1 SECOND), "%H:%i") >= ?', $end->format('H:i'));
                // else
                $builder->orWhereRaw('DATE_FORMAT(time_slots.end_at, "%H:%i") >= ?', $end->format('H:i'));
            });
            $doesntExist = $builder->doesntExist();
            if($doesntExist){
                throw new \Exception('Votre consultant n’est pas disponible pour pour cette durée. Veuillez essayer un autre créneau.');
            }
        }else{
            // Verify start date
            $weekday = $start->weekday();
            $builder->where('time_slots.weekday', '=', $weekday);
            $builder->whereRaw('DATE_FORMAT(time_slots.start_at, "%H:%i") <= ?', $start->format('H:i'));
            $builder->where('time_slots.end_at', '=', '00:00:00');
            $doesntExist = $builder->doesntExist();
            if($doesntExist){
                throw new \Exception('Votre consultant n’est pas disponible pour pour cette durée. Veuillez essayer un autre créneau.');
            }

            // Verify end date
            $weekday = $end->weekday();
            $builder->where('time_slots.weekday', '=', $weekday);
            $builder->where('time_slots.start_at', '=', '00:00:00');
            $builder->whereRaw('DATE_FORMAT(time_slots.end_at, "%H:%i") >= ?', $end->format('H:i'));
            $doesntExist = $builder->doesntExist();
            if($doesntExist){
                throw new \Exception('Votre consultant n’est pas disponible pour pour cette durée. Veuillez essayer un autre créneau.');
            }
        }

        $consultation->discipline_id = $discipline->getKey();
        $consultation->duration_id = $data['duration_id'];
        $consultation->start_at = $start;
        $consultation->end_at = $end;
        $consultation->name = $duration->label . ' avec ' . $expert->first_name;
        if($consultation->save()){
            return $consultation;
        }
        return null;
    }

    public function process(Consultation $consultation): bool
    {
        $customer = $consultation->customer;
        $value = $consultation->duration->credit;
        if($customer->credit < $value){
            return false;
        }

        $credits = $customer->credits()
            ->positive()
            ->valid()
            ->orderBy('credits.valid_until', 'ASC')
            ->get();
        foreach ($credits as $credit){
            if($value === 0){
                return true;
            }

            if($credit->value >= $value){
                $credit->value -= $value;
                $credit->save();
                return true;
            }

            if($credit->value > 0){
                $value -= $credit->value;
                $credit->value = 0;
                $credit->save();
            }
        }

        return false;
    }
}
