<?php

namespace App\Http\Controllers\Api\v1\Admin\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Shop\OrderRequest;
use App\Http\Resources\Admin\Shop\OrderCollection;
use App\Http\Resources\Admin\Shop\OrderResource;
use App\Models\Shop\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Order::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Order $order
     * @return OrderCollection
     */
    public function index(Request $request, Order $order): OrderCollection
    {
        $builder = Order::query();

        $builder->latest();

        $this->with($request, $order, $builder);

        $search = $request->get('s');
        if(!empty($search)){
            $builder->where(function (Builder $builder) use ($search) {
                $builder->orWhere('name', 'LIKE', "%$search%");
                $builder->orWhere('description', 'LIKE', "%$search%");
            });
        }

        $status = $request->get('status');
        if(!empty($status)){
            $status = strtolower($status);
            $builder->where('status', '=', $status);
        }

        $perPage = $request->get(self::PER_PAGE, self::MAX_PER_PAGE);
        if($perPage > 0){
            $models = $builder->paginate($perPage);
        }else{
            $models = $builder->get();
        }

        return new OrderCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return OrderResource|JsonResponse
     */
    public function store(OrderRequest $request, Order $order)
    {
        $order = $request->handle($order);
        if($order){
            return $this->show($request, $order);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Order $order
     * @return OrderResource
     */
    public function show(Request $request, Order $order): OrderResource
    {
        $this->with($request, $order);

        $order->load('items.orderable');

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return OrderResource|JsonResponse
     */
    public function update(OrderRequest $request, Order $order)
    {
        $order = $request->handle($order);
        if($order){
            return $this->show($request, $order);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param Order $order
     * @param string $status
     * @return JsonResponse
     */
    public function changeStatus(Order $order, string $status): JsonResponse
    {
        switch ($status){
            case Order::STATUS_CANCELED:
                $order->cancel();
                return response()->json([
                    'success' => true,
                ]);

            case Order::STATUS_VALIDATED:
                $order->validate();
                $order->pay();
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
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        return response()->json([
            'success' => $order->delete(),
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
        $orders = $request->input('orders');
        if (!empty($orders)){
            if ($count = Order::destroy($orders)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
