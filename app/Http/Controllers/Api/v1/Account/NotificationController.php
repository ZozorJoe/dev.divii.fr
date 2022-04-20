<?php

namespace App\Http\Controllers\Api\v1\Account;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Account\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        if($request->get('all', true)){
            $builder = $request->user()->notifications();
        }else{
            $builder = $request->user()->unreadNotifications();
        }

        $builder->latest();

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return NotificationResource::collection($models)
            ->additional(['success' => true]);
    }

    /**
     * Mark as read the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function mark(Request $request, string $id): JsonResponse
    {
        $count = $request->user()
            ->unreadNotifications()
            ->where('notifications.id', $id)
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => $count > 0,
        ]);
    }

    /**
     * Mark all as read the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function markAll(Request $request): JsonResponse
    {
        $count = $request->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => $count > 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()->notifications()->find($id);
        return response()->json([
            'success' => $notification && $notification->delete(),
        ]);
    }

    /**
     * Remove the all resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function massDelete(Request $request): JsonResponse
    {
        if($request->get('all', false)){
            $count = $request->user()->notifications()->delete();
        }else{
            $count = $request->user()->unreadNotifications()->delete();
        }
        return response()->json([
            'success' => $count > 0,
        ]);
    }
}
