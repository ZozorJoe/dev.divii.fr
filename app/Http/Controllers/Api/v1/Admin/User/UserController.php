<?php

namespace App\Http\Controllers\Api\v1\Admin\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Resources\Admin\User\UserCollection;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param User $user
     * @return UserCollection
     */
    public function index(Request $request, User $user): UserCollection
    {
        $builder = User::query();

        $builder->latest();

        $this->with($request, $user, $builder);

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

        return new UserCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return UserResource|JsonResponse
     */
    public function store(UserRequest $request, User $user)
    {
        $activity = $request->handle($user);
        if($activity){
            return $this->show($request, $user);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function show(Request $request, User $user): UserResource
    {
        $this->with($request, $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return UserResource|JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $activity = $request->handle($user);
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
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        return response()->json([
            'success' => $user->delete(),
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
        $users = $request->input('users');
        if (!empty($users)){
            if ($count = User::destroy($users)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
