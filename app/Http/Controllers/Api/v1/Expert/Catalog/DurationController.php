<?php

namespace App\Http\Controllers\Api\v1\Expert\Catalog;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Catalog\DurationRequest;
use App\Http\Resources\Admin\Catalog\DurationCollection;
use App\Http\Resources\Admin\Catalog\DurationResource;
use App\Models\Catalog\Duration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DurationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Duration $duration
     * @return DurationCollection
     */
    public function index(Request $request, Duration $duration): DurationCollection
    {
        $builder = Duration::query();

        $this->with($request, $duration, $builder);

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

        return new DurationCollection($models, $perPage > 0);
    }
}
