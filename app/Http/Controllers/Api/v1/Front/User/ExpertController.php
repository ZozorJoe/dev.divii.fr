<?php

namespace App\Http\Controllers\Api\v1\Front\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Front\User\ExpertCollection;
use App\Http\Resources\Front\User\ExpertResource;
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
        if($discipline->getKey()){
            $builder = $discipline->users();
            $builder->where('users.role', Expert::ROLE);
        }else{
            $builder = Expert::query();
        }

        $builder->where('users.is_active', '=', 1);

        $builder->orderBy('users.order');

        $this->with($request, $expert, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('users.first_name', 'LIKE', "%$search%");
                $builder->orWhere('users.last_name', 'LIKE', "%$search%");
                $builder->orWhere('users.email', 'LIKE', "%$search%");
            });
        }

        $disciplines = $request->get('disciplines');
        if(!empty($disciplines)){
            $disciplines = explode(',', $disciplines);
            $builder->whereHas('disciplines', function ($query) use ($disciplines) {
                $query->whereIn('disciplines.id', $disciplines);
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

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Expert $expert
     * @return ExpertResource
     */
    public function show(Request $request, Expert $expert): ExpertResource
    {
        $this->with($request, $expert);

        return new ExpertResource($expert);
    }
}
