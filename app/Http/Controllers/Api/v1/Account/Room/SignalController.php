<?php

namespace App\Http\Controllers\Api\v1\Account\Room;

use App\Events\Chat\Signal;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chat\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SignalController extends ApiController
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Room $room
     */
    public function store(Request $request, Room $room)
    {
        event(new Signal($room, $request->input()));
    }
}
