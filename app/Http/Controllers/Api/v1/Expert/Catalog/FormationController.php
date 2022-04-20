<?php

namespace App\Http\Controllers\Api\v1\Expert\Catalog;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Expert\Catalog\FormationRequest;
use App\Http\Resources\Expert\Catalog\FormationCollection;
use App\Http\Resources\Expert\Catalog\FormationResource;
use App\Models\Catalog\Formation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormationController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Formation::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Formation $formation
     * @return FormationCollection
     */
    public function index(Request $request, Formation $formation): FormationCollection
    {
        /** @var User $user */
        $user = $request->user();

        $builder = $user->formations();

        $this->with($request, $formation, $builder);

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

        return new FormationCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormationRequest $request
     * @param Formation $formation
     * @return FormationResource|JsonResponse
     */
    public function store(FormationRequest $request, Formation $formation)
    {
        $activity = $request->handle($formation);
        if($activity){
            $request->request->set('with', 'disciplines,image,picto');
            return $this->show($request, $formation);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Formation $formation
     * @return FormationResource
     */
    public function show(Request $request, Formation $formation): FormationResource
    {
        $this->with($request, $formation);

        return new FormationResource($formation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormationRequest $request
     * @param Formation $formation
     * @return FormationResource|JsonResponse
     */
    public function update(FormationRequest $request, Formation $formation)
    {
        $activity = $request->handle($formation);
        if($activity){
            $request->request->set('with', 'disciplines,image,picto');
            return $this->show($request, $activity);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Formation $formation
     * @return JsonResponse
     */
    public function destroy(Formation $formation): JsonResponse
    {
        return response()->json([
            'success' => $formation->delete(),
        ]);
    }
}
