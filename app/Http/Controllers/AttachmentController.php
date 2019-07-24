<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;
use App\Models\Property;
use App\Models\JobOrder;
use App\Models\JobRequest;
use App\Models\JobOrderItem;
use App\Models\JobRequestItem;
use App\Models\Attachment;
use App\Notifications\JobOrderAttachment;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request) {
      $static = $request->type;
      $data = $static::find($request->id);
      return $data->attachments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject = $request->subject_type::find($request->subject_id)->load(['jobrequest']);

        $attachment = Attachment::create([
            'user_id'     => Auth::user()->id,
            'description' => $request->description,
        ]);

        if(!empty($request->photos)) {
            foreach ($request->photos as $photo) {
                Attachment::RelateTo($attachment, $photo, 'photos');
            }
        }

        if(!empty($request->files)) {
            foreach ($request->files as $file) {
                Attachment::RelateTo($attachment, $file, 'files');
            }
        }

        if(!empty($request->videos)) {
            foreach ($request->videos as $video) {
                Attachment::RelateTo($attachment, $video, 'videos');
            }
        }

        // if(!$subject->attachments->contains($attachment->id)) {
            $subject->attachments()->attach($attachment->id);
        // }
        $subject->property->owner->notify(new JobOrderAttachment($subject->joborder, $subject->jobrequest, $subject->supplier));
        return $attachment;

    }
}
