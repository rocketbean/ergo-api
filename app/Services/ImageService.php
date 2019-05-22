<?php
namespace App\Services;
use Storage;
use Image;
use Illuminate\Support\Str;
class ImageService {
  public function setDefaultPropertyPrimary () {
    // $file = Storage::disk('local')->get('images/house.jpg');
  }

  public function process ($request) {
    $image      = $request->file('file');
    $timenow    = time();
    $fileName   = Str::random(8). '_' . $timenow . '.' . $image->getClientOriginalExtension();
    $filepath   = 'images/' . $fileName;
    $thumbfileName   = 'thumb_' . $fileName;
    $thumbfilepath   = 'images/thumb/' . $thumbfileName;
    $img = Image::make($image->getRealPath());
    $img->stream();
    Storage::disk('local')->put('public/' . $filepath, $img, 'public');
    $thumb = $img->resize(65, 65, function ($constraint) {
        $constraint->aspectRatio();                 
    });
    Storage::disk('local')->put('public/' . $thumbfilepath, $img, 'public');
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