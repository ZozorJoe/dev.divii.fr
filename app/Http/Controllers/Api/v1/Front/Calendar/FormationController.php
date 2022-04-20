<?php

namespace App\Http\Controllers\Api\v1\Front\Calendar;

use App\Http\Controllers\Api\ApiController;
use App\Models\Catalog\Formation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormationController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Formation $formation
     * @return JsonResponse
     */
    public function index(Request $request, Formation $formation): JsonResponse
    {
        $events = [];

        $start = $request->get('start');
        $start = Carbon::parse($start)->setTimezone('UTC');

        $end = $request->get('end');
        $end = Carbon::parse($end)->setTimezone('UTC');

        $date = $start->copy();
        $i = 0;
        while($date->isBefore($end)){
            $index = (int) ($i / 7);
            if(!isset($events[$index])){
                $events[$index] = [];
            }

            $formations = $this->loadFormations($date);
            $events[$index][] = [
                'date' => $date->toAtomString(),
                'formations' => $formations,
            ];

            $date->addDay();
            $i++;
        }


        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    private function loadFormations(Carbon $date)
    {
        $start = $date->copy();
        $end = $date->copy()->addDay()->subSecond();
        return Formation::where('start_at', '>=', $start)
            ->where('formations.start_at', '>', now())
            ->where('start_at', '<=', $end)
            ->with('user')
            ->get()
            ->toArray();
    }


}
