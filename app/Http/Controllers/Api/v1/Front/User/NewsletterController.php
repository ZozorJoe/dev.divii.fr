<?php

namespace App\Http\Controllers\Api\v1\Front\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Front\User\NewsletterRequest;
use Illuminate\Http\JsonResponse;

class NewsletterController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsletterRequest $request
     * @return JsonResponse
     */
    public function store(NewsletterRequest $request): JsonResponse
    {
        return $request->handle();
    }

}
