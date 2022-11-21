<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model{
  protected $table = 'video_enchere';
  protected $primaryKey = 'id_video';
  public $timestamps = false;

  public function vente(){
    return $this->belongsTo('Autoriko\Models\Enchere', 'id_vente');
  }
}
