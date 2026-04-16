<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DemandeCollection extends ResourceCollection
{
    public $collects = DemandeResource::class;

    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'count' => $this->collection->count(),
                'total' => $this->resource->total() ?? $this->collection->count(),
                'per_page' => $this->resource->perPage() ?? $this->collection->count(),
                'current_page' => $this->resource->currentPage() ?? 1,
            ],
        ];
    }
}
