<?php

namespace App\Http\Controllers\Api\v1\Customer\Contact;

use App\Events\Contact\Contact;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $content = $request->get('content');
        if(!empty($content)){
            event(new Contact($request->user(), $content));

            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }
}
