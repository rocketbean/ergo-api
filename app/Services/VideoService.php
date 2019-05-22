<?php
namespace App\Services;
use Storage;
use Image;
use FFMpeg;
use Illuminate\Support\Str;

class VideoService {
  public function process ($request) {
    $file      = $request->file('file');
    $fileName   = Str::random(8) . '_' . time() . '.' . $file->getClientOriginalExtension();
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