<?php

namespace App\Http\Requests\Admin\Shop;

use App\Models\Shop\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Handle request.
     *
     * @param Invoice $invoice
     * @param array $data
     * @return Invoice|null
     */
    public function handle(Invoice $invoice, array $data = array()): ?Invoice
    {
        $data = array_merge($this->validated(), $data);
        $invoice->fill($data);
        if($invoice->save()){
            return $invoice;
        }
        return null;
    }
}
