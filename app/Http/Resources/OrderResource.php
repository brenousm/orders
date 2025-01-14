<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'=> $resource->id,
            'requester_name'=> $resource->requester_name,
            'destination'=> $resource->destination,
            'departure'=> $resource->departure,
            'arrival'=> $resource->arrival,
            'updated_at'=> $resource->updated_at ,
            'created_at'=> $resource->created_at ,
            'status'=> new StatusResource($resource->status),  
            'user' => new UserResource($resource->user),          
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
