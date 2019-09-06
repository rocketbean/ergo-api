<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Supplier;
use App\Models\JobRequestItem;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $joboders = $this->authorizeJobOrder->load(['jobrequest']);
        foreach ($joboders as $joborder) {
            foreach ($joborder->items as $item) {
                $item->jobrequestitem = JobRequestItem::find($item->job_request_item_id);
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'primary' => $this->primaryPhoto,
            'joborders' => $joboders,
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
