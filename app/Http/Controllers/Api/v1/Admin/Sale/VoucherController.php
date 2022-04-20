<?php

namespace App\Http\Controllers\Api\v1\Admin\Sale;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Sale\VoucherRequest;
use App\Http\Resources\Admin\Sale\VoucherCollection;
use App\Http\Resources\Admin\Sale\VoucherResource;
use App\Models\Sale\Voucher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoucherController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Voucher::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Voucher $voucher
     * @return VoucherCollection
     */
    public function index(Request $request, Voucher $voucher): VoucherCollection
    {
        $builder = Voucher::query();

        $this->with($request, $voucher, $builder);

        $builder->with('model');

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('name', 'LIKE', "%$search%");
                $builder->orWhere('description', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new VoucherCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VoucherRequest $request
     * @param Voucher $voucher
     * @return VoucherResource|JsonResponse
     */
    public function store(VoucherRequest $request, Voucher $voucher)
    {
        $activity = $request->handle($voucher);
        if($activity){
            return $this->show($request, $voucher);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function show(Request $request, Voucher $voucher): VoucherResource
    {
        $this->with($request, $voucher);

        $voucher->load('model');

        return new VoucherResource($voucher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VoucherRequest $request
     * @param Voucher $voucher
     * @return VoucherResource|JsonResponse
     */
    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $activity = $request->handle($voucher);
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
     * @param Voucher $voucher
     * @return JsonResponse
     */
    public function destroy(Voucher $voucher): JsonResponse
    {
        return response()->json([
            'success' => $voucher->delete(),
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
        $vouchers = $request->input('vouchers');
        if (!empty($vouchers)){
            if ($count = Voucher::destroy($vouchers)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
