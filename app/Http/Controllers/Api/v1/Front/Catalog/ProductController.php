<?php

namespace App\Http\Controllers\Api\v1\Front\Catalog;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Front\Catalog\ProductCollection;
use App\Http\Resources\Front\Catalog\ProductResource;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends ApiController
{

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
}
