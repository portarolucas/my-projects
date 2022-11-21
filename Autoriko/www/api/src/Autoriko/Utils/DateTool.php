<?php

namespace Autoriko\Utils;

use DateTime;

class DateTool{

  //Check if date is correct | DATEFORMAT : (month, day, year)
  static public function checkDate($date){
    $tempDate = explode('-', $date);
    if(sizeof($tempDate) == 3){
      return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }else
      return false;
  }
}
