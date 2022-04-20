<?php

namespace App\Http\Controllers\Api\v1\Admin\Sale;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Sale\CouponRequest;
use App\Http\Resources\Admin\Sale\CouponCollection;
use App\Http\Resources\Admin\Sale\CouponResource;
use App\Models\Sale\Coupon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Coupon::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Coupon $coupon
     * @return CouponCollection
     */
    public function index(Request $request, Coupon $coupon): CouponCollection
    {
        $builder = Coupon::query();

        $this->with($request, $coupon, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('name', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new CouponCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return CouponResource|JsonResponse
     */
    public function store(CouponRequest $request, Coupon $coupon)
    {
        $activity = $request->handle($coupon);
        if($activity){
            return $this->show($request, $coupon);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Coupon $coupon
     * @return CouponResource
     */
    public function show(Request $request, Coupon $coupon): CouponResource
    {
        $this->with($request, $coupon);

        return new CouponResource($coupon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return CouponResource|JsonResponse
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $activity = $request->handle($coupon);
        if($activity){
            return $this->show($request, $activity);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Toggle  the specified resource in storage.
     *
     * @param Request $request
     * @param Coupon $coupon
     * @return JsonResponse
     */
    public function toggle(Request $request, Coupon $coupon): JsonResponse
    {
        $coupon->active = !$coupon->active;
        if($coupon->save()){
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Coupon $coupon
     * @return JsonResponse
     */
    public function destroy(Coupon $coupon): JsonResponse
    {
        return response()->json([
            'success' => $coupon->delete(),
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
        $coupons = $request->input('coupons');
        if (!empty($coupons)){
            if ($count = Coupon::destroy($coupons)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
