<?php

namespace App\FMS\Supplier\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
        ];
    }
}
