<?php

namespace Autoriko\Utils;

class Token{

  public static function generate_uuid($model){
    $uuid = random_bytes(16);
    $uuid = bin2hex($uuid);
    if($model::where('uuid', $uuid)->exists()){
      return self::generate_uuid($model);
    }else{
      return $uuid;
    }
  }
  public static function generate_random_name($model, $column){
    $name = random_bytes(16);
    $name = bin2hex($name);
    if($model::where($column, $name)->exists()){
      return self::generate_random_name($model);
    }else{
      return $name;
    }
  }
}
