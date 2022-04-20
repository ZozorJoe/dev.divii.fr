<?php

namespace App\Http\Controllers\Api\v1\Admin\Catalog\Discipline;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\User\ExpertCollection;
use App\Models\Catalog\Discipline;
use App\Models\User;
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
        //$this->authorizeResource(Expert::class);
    }

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
        $builder = Expert::query();

        $builder->distinct('users.id');

        $builder->selectRaw('IF(discipline_user.discipline_id IS NULL, 0, 1) as status');
        $builder->addSelect('users.*');

        $builder->leftJoin('discipline_user', function ($join) use ($discipline) {
            $join->on('users.id', '=', 'discipline_user.user_id');
            $join->where('discipline_user.discipline_id', '=', $discipline->getKey());
        });

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('users.first_name', 'LIKE', "%$search%");
                $builder->orWhere('users.last_name', 'LIKE', "%$search%");
                $builder->orWhere('users.email', 'LIKE', "%$search%");
            });
        }

        if($request->has('status')){
            $status = (int) $request->get('status', 1);
            if($status){
                $builder->whereNotNull('discipline_user.discipline_id');
            }else{
                $builder->whereNull('discipline_user.discipline_id');
            }
        }

        $this->with($request, $expert, $builder);

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new ExpertCollection($models, $perPage > 0);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Discipline $discipline
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Discipline $discipline, $id): JsonResponse
    {
        /** @var Expert $expert */
        $expert = User::findOrFail($id);

        return response()->json([
            'success' => $expert->delete(),
        ]);
    }

    /**
     * Mass delete the specified resource from storage.
     *
     * @param Request $request
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function massDelete(Request $request, Discipline $discipline): JsonResponse
    {
        $experts = $request->input('experts');
        if (!empty($experts)){
            $count = $discipline->users()
                ->whereIn('users.id', $experts)
                ->delete();
            if ($count) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }

    /**
     * Toggle status ofs resource in storage.
     *
     * @param Discipline $discipline
     * @param $id
     * @return JsonResponse
     */
    public function toggle(Discipline $discipline, $id): JsonResponse
    {
        $user = Expert::findOrFail($id);

        $model = $discipline->users()->find($user->getKey());

        $discipline->users()->detach($user->getKey());
        if(!$model) {
            $discipline->users()->attach($user->getKey());
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Mass attach the specified resource from storage.
     *
     * @param Request $request
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function massAttach(Request $request, Discipline $discipline): JsonResponse
    {
        $experts = $request->input('experts');
        if (!empty($experts)){
            foreach ($experts as $expert){
                $discipline->users()->detach($expert);
                $discipline->users()->attach($expert);
            }

            return response()->json(['success' => true,]);
        }

        return response()->json(['success' => false,]);
    }

    /**
     * Mass detach the specified resource from storage.
     *
     * @param Request $request
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function massDetach(Request $request, Discipline $discipline): JsonResponse
    {
        $experts = $request->input('experts');
        if (!empty($experts)){
            $discipline->users()->detach($experts);

            return response()->json(['success' => true,]);
        }

        return response()->json(['success' => false,]);
    }
}
