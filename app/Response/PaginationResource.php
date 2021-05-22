<?php

namespace App\Response;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data' => $this->items(),
            'meta' => [
                'current_page' => $this->currentPage(),
                'first_page_url' => $this->url(1),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'prev_page_url' => $this->previousPageUrl(),
                'total' => $this->total(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'from' => $this->firstItem(),
                'to'=> $this->lastItem(),
                // 'path' => $this->path(),
                'last_page' => $this->lastPage(),
            ]
        ];
    }
}