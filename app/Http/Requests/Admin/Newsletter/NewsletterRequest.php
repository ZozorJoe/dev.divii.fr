<?php

namespace App\Http\Requests\Admin\Newsletter;

use App\Models\Newsletter\Newsletter;
use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
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
            'status' => 'required',
            'content' => 'required',
        ];
    }

    /**
     * Handle request.
     *
     * @param Newsletter $newsletter
     * @param array $data
     * @return Newsletter|null
     */
    public function handle(Newsletter $newsletter, array $data = array()): ?Newsletter
    {
        $data = array_merge($this->validated(), $data);
        $newsletter->fill($data);
        if($newsletter->save()){
            return $newsletter;
        }
        return null;
    }
}
