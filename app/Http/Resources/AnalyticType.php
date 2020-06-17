<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticType extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Remove extra fields
        return [
            "id"                    => $this->id,
            "name"                  => $this->name,
            "units"                 => $this->units,
            "is_numeric"            => $this->is_numeric,
            "num_decimal_places"    => $this->num_decimal_places
        ];
    }
}
