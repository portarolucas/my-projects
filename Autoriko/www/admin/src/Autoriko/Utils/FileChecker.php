<?php

namespace Autoriko\Utils;

class FileChecker{
  public static function checkFile($file, $target_file, $authorized_type = null, $max_size = 1000000){

    $file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if(file_exists($target_file)) {
      var_dump($file["name"] . " - Problem : File exist : target file : " . $target_file);
      exit(0);
      return false;
    }

    // Check file size
    if($file["size"] > $max_size) {
      var_dump($file["name"] . " - Problem : Size : actual size : " . $file["size"]);
      exit(0);
      return false;
    }

    // Allow certain file formats
    if($authorized_type == null || in_array($file_type, $authorized_type)) {
      var_dump($file["name"] . " - Problem : Allow certain file formats  : actual type : " . $file_type);
      exit(0);
      return false;
    }

    return true;
  }

  public static function checkImage($file){
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
      return true;
    } else {
      return false;
    }
  }
}
