<?php

namespace App\Http\Requests\Admin\Zodiac;

use App\Events\Zodiac\HoroscopeCreated;
use App\Events\Zodiac\HoroscopeUpdated;
use App\Models\Zodiac\Horoscope;
use Illuminate\Foundation\Http\FormRequest;

class HoroscopeRequest extends FormRequest
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
            'status' => 'required',
            'belier' => 'required',
            'taureau' => 'required',
            'gemeaux' => 'required',
            'cancer' => 'required',
            'lion' => 'required',
            'vierge' => 'required',
            'balance' => 'required',
            'scorpion' => 'required',
            'sagittaire' => 'required',
            'capricorne' => 'required',
            'verseau' => 'required',
            'poissons' => 'required',
        ];
    }

    /**
     * Handle request.
     *
     * @param Horoscope $horoscope
     * @param array $data
     * @return Horoscope|null
     */
    public function handle(Horoscope $horoscope, array $data = array()): ?Horoscope
    {
        $data = array_merge($this->validated(), $data);
        $horoscope->fill($data);
        if($horoscope->save()){
            if($horoscope->wasRecentlyCreated){
                event(new HoroscopeCreated($horoscope));
            }else{
                event(new HoroscopeUpdated($horoscope));
            }
            return $horoscope;
        }
        return null;
    }
}
