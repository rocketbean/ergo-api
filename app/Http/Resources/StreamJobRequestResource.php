<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StreamJobRequestResource extends JsonResource
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
            'approved_by' => $this->approved_by,
            'description' => $this->description,
            'files' => $this->files,
            'photos' => $this->photos,
            'items' => $this->pendingItems,
            'job_order_id' => $this->job_order_id,
            'tags' => $this->tags,
            'uploaderData' => $this->uploaderData,
            'name' => $this->name,
            'videos' => $this->videos,
            'property' => $this->property,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans()
        ];
    }
}
