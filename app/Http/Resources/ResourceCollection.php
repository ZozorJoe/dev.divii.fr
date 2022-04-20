<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;

class ResourceCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{
    /**
     * @var bool
     */
    protected $paginated;

    public function __construct($resource, bool $paginated = true)
    {
        parent::__construct($resource);
        $this->paginated = $paginated;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'success' => true,
            'data' => $this->collection,
        ];

        if($this->paginated){
            $data['meta'] = [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage()
            ];
        }

        return $data;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        return (new ResourceResponse($this))->toResponse($request);
    }
}
