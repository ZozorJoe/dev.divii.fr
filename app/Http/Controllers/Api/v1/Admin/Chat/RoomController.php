<?php

namespace App\Http\Controllers\Api\v1\Admin\Chat;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Chat\RoomRequest;
use App\Http\Resources\Admin\Chat\RoomCollection;
use App\Http\Resources\Admin\Chat\RoomResource;
use App\Models\Chat\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Room::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Room $room
     * @return RoomCollection
     */
    public function index(Request $request, Room $room): RoomCollection
    {
        $builder = Room::query();

        $this->with($request, $room, $builder);

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

        return new RoomCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomRequest $request
     * @param Room $room
     * @return RoomResource|JsonResponse
     */
    public function store(RoomRequest $request, Room $room)
    {
        $activity = $request->handle($room);
        if($activity){
            return $this->show($request, $room);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Room $room
     * @return RoomResource
     */
    public function show(Request $request, Room $room): RoomResource
    {
        $this->with($request, $room);

        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoomRequest $request
     * @param Room $room
     * @return RoomResource|JsonResponse
     */
    public function update(RoomRequest $request, Room $room)
    {
        $activity = $request->handle($room);
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
     * @param Room $room
     * @return JsonResponse
     */
    public function destroy(Room $room): JsonResponse
    {
        return response()->json([
            'success' => $room->delete(),
        ]);
    }
}
