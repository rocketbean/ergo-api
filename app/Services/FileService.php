<?php
namespace App\Services;

use Storage;
use Image;
use File;
use Illuminate\Support\Str;

class FileService {
  public function process ($request) {
    $file      = $request->file('file');
    $fileName   = Str::random(8). '_' . time() . '.' . $file->getClientOriginalExtension();
    $filepath   = 'files/'  ;
    Storage::disk('local')->putFileAs($filepath, $file, $fileName);
    return $this->returnObj($filepath, $file->getClientOriginalExtension(),$fileName);
  }

  public function returnObj ($file, $ext, $fileName) {
    return [
      'filename' => $fileName,
      'ext' => $ext,
      'path' => $file,
    ];
  }
}