<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->resource == null)
            return [];
        else if(is_countable($this->resource))
            return self::renderList($this->resource);
        else
            return self::renderSingleElement($this->resource);
    }
    
    /**
     * Render a single element
     * 
     * @return Object
     */
    public function renderSingleElement($resource){
        return [
            'id' => $resource->id,
            'name' => $resource->name           
        ];
    }

    /**
     * Render a list os elements
     * 
     * @return array<string, mixed>
     */
    public function renderList($resourceList){
        $data = [];

        foreach ($resourceList as $item) {
            array_push($data,self::renderSingleElement($item));
        }
        return $data;
    }
}
