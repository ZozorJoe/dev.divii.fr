<?php

namespace App\Http\Controllers\Api\v1\Front\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Front\Catalog\DisciplineCollection;
use App\Models\Catalog\Discipline;
use App\Models\User\Expert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DisciplineController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Expert $expert
     * @param Discipline $discipline
     * @return DisciplineCollection
     */
    public function index(Request $request, Expert $expert, Discipline $discipline): DisciplineCollection
    {
        $builder = $expert->disciplines();

        $builder->wherePivot('durations', '!=', null);

        $this->with($request, $discipline, $builder);
        $this->withCount($request, $discipline, $builder);

        $builder->where('is_active', true);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('name', 'LIKE', "%$search%");
                $builder->orWhere('description', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new DisciplineCollection($models, $perPage > 0);
    }
}
