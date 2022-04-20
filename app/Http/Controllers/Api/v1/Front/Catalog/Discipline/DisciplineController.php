<?php

namespace App\Http\Controllers\Api\v1\Front\Catalog\Discipline;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Front\Catalog\DisciplineCollection;
use App\Http\Resources\Front\Catalog\DisciplineResource;
use App\Models\Catalog\Discipline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DisciplineController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Discipline $discipline
     * @return DisciplineCollection
     */
    public function index(Request $request, Discipline $discipline): DisciplineCollection
    {
        $builder = Discipline::query();

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

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Discipline $discipline
     * @return DisciplineResource
     */
    public function show(Request $request, Discipline $discipline): DisciplineResource
    {
        $this->with($request, $discipline);

        return new DisciplineResource($discipline);
    }
}
