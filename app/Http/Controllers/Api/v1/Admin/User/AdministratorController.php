<?php

namespace App\Http\Controllers\Api\v1\Admin\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\User\AdministratorRequest;
use App\Http\Resources\Admin\User\AdministratorCollection;
use App\Http\Resources\Admin\User\AdministratorResource;
use App\Models\User\Administrator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdministratorController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Administrator::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Administrator $administrator
     * @return AdministratorCollection
     */
    public function index(Request $request, Administrator $administrator): AdministratorCollection
    {
        $builder = Administrator::query();

        $builder->latest();

        $this->with($request, $administrator, $builder);

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

        return new AdministratorCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdministratorRequest $request
     * @param Administrator $administrator
     * @return AdministratorResource|JsonResponse
     */
    public function store(AdministratorRequest $request, Administrator $administrator)
    {
        $activity = $request->handle($administrator);
        if($activity){
            return $this->show($request, $administrator);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Administrator $administrator
     * @return AdministratorResource
     */
    public function show(Request $request, Administrator $administrator): AdministratorResource
    {
        $this->with($request, $administrator);

        return new AdministratorResource($administrator);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdministratorRequest $request
     * @param Administrator $administrator
     * @return AdministratorResource|JsonResponse
     */
    public function update(AdministratorRequest $request, Administrator $administrator)
    {
        $activity = $request->handle($administrator);
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
     * @param Administrator $administrator
     * @return JsonResponse
     */
    public function destroy(Administrator $administrator): JsonResponse
    {
        return response()->json([
            'success' => $administrator->delete(),
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
        $administrators = $request->input('administrators');
        if (!empty($administrators)){
            if ($count = Administrator::destroy($administrators)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
