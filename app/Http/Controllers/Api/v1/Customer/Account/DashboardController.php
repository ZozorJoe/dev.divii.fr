<?php

namespace App\Http\Controllers\Api\v1\Customer\Account;

use App\Http\Controllers\Api\ApiController;
use App\Models\Catalog\Formation;
use App\Models\Shop\Consultation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    /**
     * Display a dashboard resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $formations = $user->rooms()->of(Formation::class)->count();
        $consultations = $user->rooms()->of(Consultation::class)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'count' => [
                    'formations' => $formations,
                    'consultations' => $consultations,
                ]
            ]
        ]);
    }
}
