<?php

namespace App\Http\Requests\Admin\Sale;

use App\Models\Sale\Coupon;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
        $coupon = $this->route('coupon');
        return [
            'type' => 'nullable|string',
            'active' => 'required|boolean',
            'name' => 'required|string|max:50|unique:coupons,name' . ( $coupon ? ',' . (int) $coupon->getKey() : '' ),
            'value' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ];
    }

    /**
     * Handle request.
     *
     * @param Coupon $coupon
     * @param array $data
     * @return Coupon|null
     */
    public function handle(Coupon $coupon, array $data = array()): ?Coupon
    {
        $data = array_merge($this->validated(), $data);
        $format = 'Y-m-d';

        $start = null;
        if(isset($data['start_date']) && !empty($data['start_date'])){
            $start = Carbon::createFromFormat($format . " H:i:s", date($format, strtotime($data['start_date'])). ' 00:00:00');
        }
        $data['start_date'] = $start;

        $end = null;
        if(isset($data['end_date']) && !empty($data['end_date'])){
            $end = Carbon::createFromFormat($format . " H:i:s", date($format, strtotime($data['end_date'])). ' 23:59:59');
        }
        $data['end_date'] = $end;

        $data['limit_number'] = 1;

        if(!isset($data['type']) || empty($data['type'])){
            $data['type'] = Coupon::TYPE_PERCENT;
        }

        $coupon->fill($data);
        if($coupon->save()){
            return $coupon;
        }
        return null;
    }
}
