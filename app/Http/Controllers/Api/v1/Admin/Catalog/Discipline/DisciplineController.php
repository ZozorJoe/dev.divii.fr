<?php

namespace App\Http\Controllers\Api\v1\Admin\Catalog\Discipline;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Catalog\DisciplineRequest;
use App\Http\Resources\Admin\Catalog\DisciplineCollection;
use App\Http\Resources\Admin\Catalog\DisciplineResource;
use App\Models\Catalog\Discipline;
use App\Models\User\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DisciplineController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Discipline::class);
    }

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
     * Store a newly created resource in storage.
     *
     * @param DisciplineRequest $request
     * @param Discipline $discipline
     * @return DisciplineResource|JsonResponse
     */
    public function store(DisciplineRequest $request, Discipline $discipline)
    {
        $discipline = $request->handle($discipline);
        if($discipline){
            $request->request->set('with', 'image,picto');
            return $this->show($request, $discipline);
        }

        return response()->json([
            'success' => false,
        ]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param DisciplineRequest $request
     * @param Discipline $discipline
     * @return DisciplineResource|JsonResponse
     */
    public function update(DisciplineRequest $request, Discipline $discipline)
    {
        $activity = $request->handle($discipline);
        if($activity){
            $request->request->set('with', 'image,picto');
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
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function toggle(Request $request, Discipline $discipline): JsonResponse
    {
        $discipline->is_active = !$discipline->is_active;
        if($discipline->save()){
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
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function destroy(Discipline $discipline): JsonResponse
    {
        return response()->json([
            'success' => $discipline->delete(),
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
        $disciplines = $request->input('disciplines');
        if (!empty($disciplines)){
            if ($count = Discipline::destroy($disciplines)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
