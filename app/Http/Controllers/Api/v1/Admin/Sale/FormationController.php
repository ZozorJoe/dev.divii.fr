<?php

namespace App\Http\Controllers\Api\v1\Admin\Sale;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\Chat\RoomCollection;
use App\Http\Resources\Admin\Chat\RoomResource;
use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Consultation;
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

        $builder->latest();

        $builder->whereHasMorph(
            'model',
            Formation::class,
        );

        $this->with($request, $room, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('title', 'LIKE', "%$search%");
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

    /**
     * Mass delete the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function massDelete(Request $request): JsonResponse
    {
        $rooms = $request->input('rooms');
        if (!empty($rooms)){
            if ($count = Room::destroy($rooms)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
