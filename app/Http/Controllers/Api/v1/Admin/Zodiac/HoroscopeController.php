<?php

namespace App\Http\Controllers\Api\v1\Admin\Zodiac;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Zodiac\HoroscopeRequest;
use App\Http\Resources\Admin\Zodiac\HoroscopeCollection;
use App\Http\Resources\Admin\Zodiac\HoroscopeResource;
use App\Models\Zodiac\Horoscope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HoroscopeController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Horoscope::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Horoscope $horoscope
     * @return HoroscopeCollection
     */
    public function index(Request $request, Horoscope $horoscope): HoroscopeCollection
    {
        $builder = Horoscope::query();

        $this->with($request, $horoscope, $builder);

        $builder->withCount('users');

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('first_name', 'LIKE', "%$search%");
                $builder->orWhere('last_name', 'LIKE', "%$search%");
                $builder->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new HoroscopeCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HoroscopeRequest $request
     * @param Horoscope $horoscope
     * @return HoroscopeResource|JsonResponse
     */
    public function store(HoroscopeRequest $request, Horoscope $horoscope)
    {
        $activity = $request->handle($horoscope);
        if($activity){
            return $this->show($request, $horoscope);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Horoscope $horoscope
     * @return HoroscopeResource
     */
    public function show(Request $request, Horoscope $horoscope): HoroscopeResource
    {
        $this->with($request, $horoscope);

        return new HoroscopeResource($horoscope);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HoroscopeRequest $request
     * @param Horoscope $horoscope
     * @return HoroscopeResource|JsonResponse
     */
    public function update(HoroscopeRequest $request, Horoscope $horoscope)
    {
        $activity = $request->handle($horoscope);
        if($activity){
            return $this->show($request, $activity);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Horoscope $horoscope
     * @return JsonResponse
     */
    public function destroy(Horoscope $horoscope): JsonResponse
    {
        return response()->json([
            'success' => $horoscope->delete(),
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
        $horoscopes = $request->input('horoscopes');
        if (!empty($horoscopes)){
            if ($count = Horoscope::destroy($horoscopes)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
