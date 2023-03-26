<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CategoryResource extends JsonResource
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
        $children = DB::table('categories')->where('parentId', "=", $array['id'])->get();
        $childrenIds = [];
        foreach ($children as $child) {
            $childrenIds[] = $child->id;
        }
        $array['childIds'] = $childrenIds;
        return $array;
    }
}
