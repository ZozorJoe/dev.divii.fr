<?php

namespace App\Http\Controllers\Api\v1\Account\Room;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Account\Chat\UserResource;
use App\Models\Chat\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Room $room
     * @return ResourceCollection
     */
    public function index(Request $request, Room $room): ResourceCollection
    {
        $builder = $room->users();

        $search = trim($request->get('s'));
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('email', 'LIKE', "%$search%");
                $builder->orWhere('first_name', 'LIKE', "%$search%");
                $builder->orWhere('last_name', 'LIKE', "%$search%");
                $builder->orWhere('role', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return UserResource::collection($models)
            ->additional(['success' => true]);
    }
}
