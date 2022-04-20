<?php

namespace App\Http\Controllers\Api\v1\Admin\Catalog;

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
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Duration::class);
    }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param DurationRequest $request
     * @param Duration $duration
     * @return DurationResource|JsonResponse
     */
    public function store(DurationRequest $request, Duration $duration)
    {
        $activity = $request->handle($duration);
        if($activity){
            return $this->show($request, $duration);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Duration $duration
     * @return DurationResource
     */
    public function show(Request $request, Duration $duration): DurationResource
    {
        $this->with($request, $duration);

        return new DurationResource($duration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DurationRequest $request
     * @param Duration $duration
     * @return DurationResource|JsonResponse
     */
    public function update(DurationRequest $request, Duration $duration)
    {
        $activity = $request->handle($duration);
        if($activity){
            return $this->show($request, $activity);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Duration $duration
     * @return JsonResponse
     */
    public function destroy(Duration $duration): JsonResponse
    {
        return response()->json([
            'success' => $duration->delete(),
        ]);
    }

    /**
     * Mass delete the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function massDelete(Request $request): JsonResponse
    {
        $durations = $request->input('durations');
        if (!empty($durations)){
            if ($count = Duration::destroy($durations)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
