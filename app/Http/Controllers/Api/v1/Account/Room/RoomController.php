<?php

namespace App\Http\Controllers\Api\v1\Account\Room;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Account\RoomRequest;
use App\Http\Resources\Account\RoomResource;
use App\Models\Chat\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoomController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $builder = $request->user()->rooms();

        $search = trim($request->get('s'));
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('title', 'LIKE', "%$search%");
            });
        }

        $builder->where('rooms.status', '!=', Room::STATUS_CANCELED);

        $builder->where('rooms.start_at', '>=', now()->subWeek());

        $builder->orderBy('rooms.updated_at', 'desc');

        $builder->with(['latestMessage', 'latestMessage.user']);

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return RoomResource::collection($models)
            ->additional(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomRequest $request
     * @return RoomResource|JsonResponse
     */
    public function store(RoomRequest $request)
    {
        /**
         * @var Room $room
         */
        $data = $request->all();
        $room = Room::create($data);

        if($room){
            //event(new RoomCreated($room));

            return new RoomResource($room);
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
        if($room->status === Room::STATUS_CANCELED){
            abort(404);
        }

        if($room->end_at && $room->end_at->isBefore(now()->subWeek())){
            abort(404);
        }

        /** @var User $user */
        $user = $request->user();
        $canJoin = $user->canJoin($room->getKey());
        if(!$canJoin){
            abort(403);
        }

        $room->load('user.disciplines');
        $room->load('model.customer');
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoomRequest $request
     * @param Room $room
     * @return JsonResponse
     */
    public function update(RoomRequest $request, Room $room): JsonResponse
    {
        $room = $request->handle($room);
        if($room){
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
