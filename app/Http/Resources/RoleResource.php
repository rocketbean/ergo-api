<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id' => $this->id,
           'value' => $this->id,
           'name' => $this->name,
           'label' => $this->name,
           'description' => $this->description,
           'sublabel' => $this->description,
        ];
    }
}
