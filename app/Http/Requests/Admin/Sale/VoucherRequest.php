<?php

namespace App\Http\Requests\Admin\Sale;

use App\Models\Chat\Room;
use App\Models\Sale\Voucher;
use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'status' => 'required|string|max:20',
            'content' => 'required|string|max:255',
        ];
    }

    /**
     * Handle request.
     *
     * @param Voucher $voucher
     * @param array $data
     * @return Voucher|null
     */
    public function handle(Voucher $voucher, array $data = array()): ?Voucher
    {
        return null;
    }
}
