<?php

namespace App\Http\Controllers\Api\v1\Front\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Front\Catalog\DurationCollection;
use App\Http\Resources\ResourceCollection;
use App\Models\Catalog\Discipline;
use App\Models\Catalog\Duration;
use App\Models\User\DisciplineUser;
use App\Models\User\Expert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DurationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Discipline $discipline
     * @param Expert $expert
     * @param Duration $duration
     * @return DurationCollection
     */
    public function index(Request $request, Expert $expert, Discipline $discipline, Duration $duration): DurationCollection
    {
        if($discipline->getKey()){
            $pivot = DisciplineUser::where('user_id', '=', $expert->getKey())
                ->where('discipline_id', '=', $discipline->getKey())
                ->firstOrFail();
            $builder = Duration::query();
            $builder->whereIn('id', $pivot->durations);
        }else{
            $builder = Duration::query();
        }
        $builder->orderBy('credit');
        $models = $builder->get();

        $date = $request->get('date');
        if($date){
            $app_timezone = config('app.timezone');
            $user_timezone = $request->get('timezone');
            $start = Carbon::parse($date)->setSecond(0)->setMillisecond(0)->timezone($app_timezone);
            $items = [];
            foreach ($models as $model){
                $end = $start->copy()->add($model->delay);
                if($expert->isAvailable($start, $end)){
                    $items[] = $model;
                }else{
                    return new DurationCollection($items, false);
                }
            }
            return new DurationCollection($items, false);
        }
        return new DurationCollection($models, false);
    }
}
