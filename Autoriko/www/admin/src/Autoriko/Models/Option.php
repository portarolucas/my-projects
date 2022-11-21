<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model{
  protected $table = 'option';
  protected $primaryKey = 'id_option';
  public $timestamps = false;

  public function voiture(){
    return $this->hasMany('Autoriko\Models\Voiture', 'id_voiture');
  }
}
