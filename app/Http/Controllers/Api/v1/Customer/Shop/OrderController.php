<?php

namespace App\Http\Controllers\Api\v1\Customer\Shop;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Shop\OrderRequest;
use App\Http\Resources\Admin\Shop\OrderCollection;
use App\Http\Resources\Admin\Shop\OrderResource;
use App\Models\Shop\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Order $order
     * @return OrderCollection
     */
    public function index(Request $request, Order $order): OrderCollection
    {
        /** @var User $user */
        $user = $request->user();

        $builder = $user->orders();

        $builder->latest();

        $this->with($request, $order, $builder);

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
}
