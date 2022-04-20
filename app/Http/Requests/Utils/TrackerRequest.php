<?php

namespace App\Http\Requests\Utils;

use App\Models\Utils\Tracker;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class TrackerRequest extends FormRequest
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
            'title' => 'required|string|max:255',
        ];
    }

    /**
     * Handle request.
     *
     * @param Tracker $tracker
     * @param array $data
     * @return Tracker|null
     */
    public function handle(Tracker $tracker, array $data = array()): ?Tracker
    {
        $browser = get_browser(null, true);
        $data = [
            'event' => Tracker::EVENT_CLICK,
            'status' => 200,
            'method' => 'GET',
            'host' => $data['host'] ?? null,
            'url' => $data['url'] ?? null,
            'title' => $data['title'] ?? null,
            'referer_host' => null,
            'referer' => null,
            'platform' => $browser && $browser['platform'] ? $browser['platform'] : null,
            'browser' => $browser && $browser['browser'] ? $browser['browser'] : null,
            'version' => $browser && $browser['version'] ? $browser['version'] : null,
            'ip' => $this->ip(),
            'user_id' => null,
        ];
        $tracker->save($data);
        return $tracker;
    }
}
