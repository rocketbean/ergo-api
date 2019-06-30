<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $model = "App\\Models\\" . $this->data["subject_type"];
        return [
            'id' => $this->id,
            'data' => [
                'title'     => $this->data["title"],
                'message'   => $this->data["message"],
                'subject'   => $model::find($this->data["subject"]),
                '_modals'   => $this->data["_modals"],
            ],
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
