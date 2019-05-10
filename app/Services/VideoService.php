<?php
namespace App\Services;
use Storage;
use Image;
use FFMpeg;

class VideoService {
  public function process ($request) {
    $file      = $request->file('file');
    $fileName   = time() . '.' . $file->getClientOriginalExtension();
    $filepath   = 'videos/'  ;
    Storage::disk('local')->putFileAs($filepath, $file, $fileName);
    return $this->returnObj($filepath, $file->getClientOriginalExtension(),$fileName);
  }

  public function returnObj ($file, $ext, $fileName) {
    return [
      'filename' => $fileName,
      'ext' => $ext,
      'thumb' => 'thumb',
      'path' => $file,
    ];
  }
}