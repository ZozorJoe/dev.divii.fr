<?php

namespace App\Http\Controllers\Api\v1\Utils;

use App\Http\Controllers\Controller;
use Carbon\CarbonTimeZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Monarobase\CountryList\CountryListFacade as Countries;

class TzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = [];

        $hour = now()->timezone('UTC')->format("H:i");
        $data[] = [
            'id' => 'UTC',
            'code' => 'UTC',
            'country' => 'UTC',
            'label' => "Heure UTC ($hour)",
        ];

        $countries = Countries::getList('fr');
        foreach($countries as $code => $country){
            $item = CarbonTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $code);
            if($item){
                $hour = now()->timezone($item[0])->format("H:i");
                $data[] = [
                    'id' => $item[0],
                    'code' => $code,
                    'country' => $country,
                    'label' => "Heure de $country ($hour)",
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
