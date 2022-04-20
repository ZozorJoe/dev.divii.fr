<?php

namespace App\Http\Controllers\Api\v1\Admin\User\Expert;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\User\ExpertRequest;
use App\Http\Resources\Admin\User\ExpertCollection;
use App\Http\Resources\Admin\User\ExpertResource;
use App\Models\User\Expert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpertController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Expert::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Expert $expert
     * @return ExpertCollection
     */
    public function index(Request $request, Expert $expert): ExpertCollection
    {
        $builder = Expert::query();

        $this->with($request, $expert, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('first_name', 'LIKE', "%$search%");
                $builder->orWhere('last_name', 'LIKE', "%$search%");
                $builder->orWhere('email', 'LIKE', "%$search%");
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
     * Store a newly created resource in storage.
     *
     * @param ExpertRequest $request
     * @param Expert $expert
     * @return ExpertResource|JsonResponse
     */
    public function store(ExpertRequest $request, Expert $expert)
    {
        $activity = $request->handle($expert);
        if($activity){
            $request->request->set('with', 'disciplines,timeSlots,avatar,picto');
            return $this->show($request, $expert);
        }

        return response()->json([
            'success' => false,
        ]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param ExpertRequest $request
     * @param Expert $expert
     * @return ExpertResource|JsonResponse
     */
    public function update(ExpertRequest $request, Expert $expert)
    {
        $activity = $request->handle($expert);
        if($activity){
            $request->request->set('with', 'disciplines,timeSlots,avatar,picto');

            return $this->show($request, $activity);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Toggle  the specified resource in storage.
     *
     * @param Request $request
     * @param Expert $expert
     * @return JsonResponse
     */
    public function toggle(Request $request, Expert $expert): JsonResponse
    {
        $expert->is_active = !$expert->is_active;
        if($expert->save()){
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Expert $expert
     * @return JsonResponse
     */
    public function destroy(Expert $expert): JsonResponse
    {
        return response()->json([
            'success' => $expert->delete(),
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
        $experts = $request->input('experts');
        if (!empty($experts)){
            if ($count = Expert::destroy($experts)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
