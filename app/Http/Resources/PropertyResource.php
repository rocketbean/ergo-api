<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\PropertyUser;
use App\Models\Property;
class PropertyResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'primary' => $this->primaryPhoto,
            'jobrequests' => $this->authorizeJobRequest->load(['joborders']),
            'users' => $this->authorized('read_user') ? $this->users : false,
            'location' => $this->location,
            'photos' => $this->photos,
            'videos' => $this->videos,
            'files' => $this->files,
            'role' => $this->role(),//(new PropertyUser)->userBridge(Property::find($this->id)),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans()
        ];
    }
}
