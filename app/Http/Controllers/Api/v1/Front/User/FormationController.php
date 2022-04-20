<?php

namespace App\Http\Controllers\Api\v1\Front\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Front\Catalog\FormationCollection;
use App\Models\Catalog\Formation;
use App\Models\User\Expert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FormationController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Expert $expert
     * @param Formation $formation
     * @return FormationCollection
     */
    public function index(Request $request, Expert $expert, Formation $formation): FormationCollection
    {
        $builder = $expert->formations();

        $this->with($request, $formation, $builder);

        $builder->orderBy('formations.start_at');

        $builder->where('formations.start_at', '>=', now());

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('formations.name', 'LIKE', "%$search%");
                $builder->orWhere('formations.description', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new FormationCollection($models, $perPage > 0);
    }
}
