<?php

namespace App\Http\Requests\Admin\Catalog;

use App\Models\Catalog\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|min:3|max:3',
        ];
    }

    /**
     * Handle request.
     *
     * @param Product $product
     * @param array $data
     * @return Product|null
     */
    public function handle(Product $product, array $data = array()): ?Product
    {
        $data = array_merge($this->validated(), $data);
        $product->fill($data);
        if($product->save()){
            return $product;
        }
        return null;
    }
}
