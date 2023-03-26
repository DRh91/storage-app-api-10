<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomShoppingItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $createdAt = $this->created_at->format('Y-m-d H:i:s');
        $updatedAt = $this->updated_at->format('Y-m-d H:i:s');
        $array = parent::toArray($request);
        $array['created_at'] = $createdAt;
        $array['updated_at'] = $updatedAt;
        return $array;
    }
}
