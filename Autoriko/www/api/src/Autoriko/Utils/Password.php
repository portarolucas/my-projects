<?php

namespace Autoriko\Utils;

class Password{
  public static function check_valid_password($password){
    $min_characters = 5;
    if(strlen($password) >= $min_characters){
      return true;
    }
  }

  public static function verifyPassword($password, $db_password) {
    return password_verify($password, $db_password);
  }

  public static function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
  }
}
