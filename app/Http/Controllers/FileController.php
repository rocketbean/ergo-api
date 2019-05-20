<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(preg_match("/image/i", ($request->file->getMimeType()))) {
            $photo = (new PhotoController)->store($request);
        } else if (preg_match("/video/i", $request->file->getMimeType())) {
            $video = (new VideoController)->store($request);
        } else {
            $fp = (new FileService)->process($request);
            $file = File::create([
              'user_id'  => Auth::user()->id,
              'filename' => $fp['filename'],
              'ext'      => $fp['ext'],
              'path'     => $fp['path'],
            ]);
            $file->users()->attach(Auth::user()->id);
        }

        return [
            'video' => isset($video) ?  $video : null,
            'photo' => isset($photo) ? $photo : null,
            'file' => isset($file) ? $file : null,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
