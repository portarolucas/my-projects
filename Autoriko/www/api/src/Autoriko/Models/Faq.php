<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model{
  protected $table = 'faq';
  protected $primaryKey = 'id_faq';
  public $timestamps = false;

  public function admin(){
    return $this->belongsTo('Autoriko\Models\Admin', 'id_admin');
  }
}
