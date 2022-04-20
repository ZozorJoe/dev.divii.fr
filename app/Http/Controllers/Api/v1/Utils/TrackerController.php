<?php

namespace App\Http\Controllers\Api\v1\Utils;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Utils\TrackerRequest;
use App\Models\Utils\Tracker;
use Illuminate\Http\JsonResponse;

class TrackerController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TrackerRequest $request
     * @param Tracker $tracker
     * @return JsonResponse
     */
    public function store(TrackerRequest $request, Tracker $tracker): JsonResponse
    {
        $tracker = $request->handle($tracker);
        if($tracker){
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }
}
