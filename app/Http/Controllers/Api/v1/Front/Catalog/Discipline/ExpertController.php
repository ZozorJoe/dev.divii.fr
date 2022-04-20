<?php

namespace App\Http\Controllers\Api\v1\Front\Catalog\Discipline;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Front\User\ExpertCollection;
use App\Models\Catalog\Discipline;
use App\Models\User\Expert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ExpertController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Discipline $discipline
     * @param Expert $expert
     * @return ExpertCollection
     */
    public function index(Request $request, Discipline $discipline, Expert $expert): ExpertCollection
    {
        $builder = $discipline->experts();

        $builder->where('users.is_active', '=', 1);

        $builder->orderBy('users.order');

        $this->with($request, $expert, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('first_name', 'LIKE', "%$search%");
                $builder->orWhere('last_name', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new ExpertCollection($models, $perPage > 0);
    }
}
