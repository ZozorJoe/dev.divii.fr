<?php

namespace App\Http\Requests\Front\User;

use App\Models\Newsletter\Newsletter;
use App\Services\Mailchimp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

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
            'email' => 'required|email',
        ];
    }

    /**
     * Handle request.
     *
     * @param array $data
     * @return JsonResponse
     */
    public function handle(array $data = array()): JsonResponse
    {
        $data = array_merge($this->validated(), $data);
        try {
            /*ss
            $exists = Newsletter::where('email', '=', $data['email'])->exists();
            if($exists){
                return response()->json([
                    'success' => false,
                    'message' => "Vous êtes déjà inscrit à notre newsletter!",
                ]);
            }else{
                Newsletter::create($data);
            }
            */
            Mailchimp::subscribe($data['email']);
            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
