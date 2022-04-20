<?php

namespace App\Http\Controllers\Api\v1\Account\Room;

use App\Events\Chat\MessageCreated;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Account\MessageRequest;
use App\Http\Resources\Account\MessageResource;
use App\Models\Chat\Message;
use App\Models\Chat\MessageUser;
use App\Models\Chat\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->authorizeResource(Message::class, 'message');
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
        $builder = $room->messages();
        $builder->latest();
        $builder->with('user');

        $search = trim($request->get('s'));
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('content', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        $ids = $models->pluck('id');
        if($ids->isNotEmpty()){
            /** @var User $user */
            $user = $request->user();
            MessageUser::where('user_id', '=', $user->getKey())
                ->whereIn('message_id', $ids)
                ->where('is_seen', '=', false)
                ->update(['is_seen' => true]);
        }

        return MessageResource::collection($models)
            ->additional(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MessageRequest $request
     * @param Room $room
     * @return MessageResource|JsonResponse
     */
    public function store(MessageRequest $request, Room $room)
    {
        /**
         * @var Message $message
         */
        $data = $request->all();
        $message = $room->messages()->create($data);

        if($message){
            $message->load('user');

            event(new MessageCreated($message));

            return new MessageResource($message);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Message $message
     * @return MessageResource
     */
    public function show(Message $message): MessageResource
    {
        return new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MessageRequest $request
     * @param Message $message
     * @return MessageResource|JsonResponse
     */
    public function update(MessageRequest $request, Message $message)
    {
        $data = $request->all();
        if($message->update($data)){
            return new MessageResource($message);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function destroy(Message $message): JsonResponse
    {
        return response()->json([
            'success' => $message->delete(),
        ]);
    }
}
