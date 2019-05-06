<?php
namespace App\Services;
use Storage;
use Image;

class ImageService {
  public function process ($request) {
    $image      = $request->file('file');
    $timenow    = time();
    $fileName   = $timenow . '.' . $image->getClientOriginalExtension();
    $filepath   = 'images/' . $fileName;
    $thumbfileName   = $timenow . '_thumb.' . $image->getClientOriginalExtension();
    $thumbfilepath   = 'images/thumb' . $thumbfileName;
    $img = Image::make($image->getRealPath());
    $img->stream();
    Storage::disk('local')->put($filepath, $img, 'public');
    $thumb = $img->resize(65, 65, function ($constraint) {
        $constraint->aspectRatio();                 
    });
    Storage::disk('local')->put($thumbfilepath, $img, 'public');
    return $this->returnObj($filepath, $thumbfilepath, $image->getClientOriginalExtension(),$fileName);
  }

  public function returnObj ($file, $thumb, $ext, $fileName) {
    return [
      'filename' => $fileName,
      'ext' => $ext,
      'thumb' => $thumb,
      'path' => $file,
    ];
  }
}