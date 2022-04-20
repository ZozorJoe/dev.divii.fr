<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Handle eager loader
     */
    public function with(Request $request, Model $model, $builder = null)
    {
        $with = $request->get('with');
        if(!empty($with)){
            $relations = explode(',', $with);
            foreach ($relations as $relation) {
                if($model->isRelation($relation)) {
                    if($builder){
                        $builder->with($relation);
                    }else{
                        $model->load($relation);
                    }
                }
            }
        }
    }

    /**
     * Handle eager loader
     */
    public function withCount(Request $request, Model $model, $builder = null)
    {
        $count = $request->get('count');
        if(!empty($count)){
            $relations = explode(',', $count);
            foreach ($relations as $relation) {
                $subs = explode('.', $relation);
                if($model->isRelation($subs[0])) {
                    if($builder){
                        $builder->withCount($relation);
                    }else{
                        $model->loadCount($relation);
                    }
                }
            }
        }
    }
}
