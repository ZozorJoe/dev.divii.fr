<?php

namespace App\Http\Controllers\Api\v1\Expert\Sale;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Admin\Chat\RoomCollection;
use App\Http\Resources\Admin\Chat\RoomResource;
use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormationController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Room $room
     * @return RoomCollection
     */
    public function index(Request $request, Room $room): RoomCollection
    {
        /** @var User $user */
        $user = $request->user();

        $builder = Room::query();

        $builder->latest();

        $builder->whereHasMorph(
            'model',
            Formation::class,
        );

        $builder->where('rooms.user_id', '=', $user->getKey());

        $this->with($request, $room, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('title', 'LIKE', "%$search%");
            });
        }

        $app_timezone = config('app.timezone');
        $user_timezone = $request->get('timezone', $app_timezone);
        $now = now();
        $filter = (int) $request->get('filter', 0);
        switch ($filter){
            case -1:
                $builder->where('rooms.end_at', '<', $now);
                break;
            case 1:
                $builder->where('rooms.start_at', '>', $now);
                break;
            default:
                $builder->whereDate('rooms.start_at', '=', $now);
                //$builder->where('rooms.end_at', '>', now());
                break;
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function events(Request $request): JsonResponse
    {
        $user_timezone = $request->get('timezone');
        $app_timezone = config('app.timezone');
        $date = Carbon::parse($request->get('date'));
        $start = $date->copy()->timezone($user_timezone)->startOfMonth()->timezone($app_timezone);
        $end = $date->copy()->timezone($user_timezone)->endOfMonth()->timezone($app_timezone);

        /** @var User $user */
        $user = $request->user();
        $builder = Room::query();
        $builder->where('rooms.user_id', '=', $user->getKey());
        $builder->whereHasMorph(
            'model',
            Formation::class,
        );
        $builder->where('rooms.status', '=', Room::STATUS_VALIDATED);
        $builder->where('rooms.start_at', '>=', $start);
        $builder->where('rooms.start_at', '<=', $end);

        /** @var Room[] $models */
        $models = $builder->get();

        $events = [];
        foreach ($models as $model){
            $key = $model->start_at->toDateString();
            if(!isset($events[$key])){
                $events[$key] = [
                    'date' => $date->toAtomString(),
                    'items' => [],
                ];
            }
            /** @var Formation $formation */
            $formation = $model->model;
            $events[$key]['items'][] = [
                'formation' => $formation ? [
                    'id' => $formation->getKey(),
                    'name' => $formation->name,
                ] : null,
                'start' => $model->start_at->toAtomString(),
                'end' => $model->end_at->toAtomString(),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $events,
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
