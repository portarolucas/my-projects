<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Video_voiture extends Model{
  protected $table = 'video_voiture';
  protected $primaryKey = 'id_video';
  public $timestamps = false;

  public function voiture(){
    return $this->hasMany('Autoriko\Models\Voiture', 'id_video');
  }
}
