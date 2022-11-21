<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model{
  protected $table = 'vente';
  protected $primaryKey = 'id_vente';
  public $timestamps = true;

  protected $guarded = ['id_vente', 'uuid', 'id_achat', 'id_admin', 'created_at', 'updated_at', 'deleted_at'];

  public function achat(){
    return $this->belongsTo('Autoriko\Models\Achat', 'id_achat');
  }

  public function admin(){
    return $this->belongsTo('Autoriko\Models\Admin', 'id_administrateur');
  }

  public function car(){
    return $this->belongsTo('Autoriko\Models\Voiture', 'id_voiture');
  }

  public function photo_thumbnail(){
    return $this->belongsTo('Autoriko\Models\PhotoVoiture', 'photo_thumbnail');
  }
}
