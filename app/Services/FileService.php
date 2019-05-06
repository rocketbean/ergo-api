<?php
namespace App\Services;
use Storage;
use Image;
use File;
class FileService {
  public static function getMime ($file) {
    // return File::mimeType($file)
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