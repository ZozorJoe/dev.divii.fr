<?php

namespace App\Http\Controllers\Api\v1\Admin\Catalog;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\Catalog\ProductRequest;
use App\Http\Resources\Admin\Catalog\ProductCollection;
use App\Http\Resources\Admin\Catalog\ProductResource;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Product $product
     * @return ProductCollection
     */
    public function index(Request $request, Product $product): ProductCollection
    {
        $builder = Product::query();

        $this->with($request, $product, $builder);

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

        return new ProductCollection($models, $perPage > 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return ProductResource|JsonResponse
     */
    public function store(ProductRequest $request, Product $product)
    {
        $activity = $request->handle($product);
        if($activity){
            return $this->show($request, $product);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Product $product
     * @return ProductResource
     */
    public function show(Request $request, Product $product): ProductResource
    {
        $this->with($request, $product);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return ProductResource|JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $activity = $request->handle($product);
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
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        return response()->json([
            'success' => $product->delete(),
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
        $products = $request->input('products');
        if (!empty($products)){
            if ($count = Product::destroy($products)) {
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            }
        }

        return response()->json(['success' => false]);
    }
}
