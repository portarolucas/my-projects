<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model{
  protected $table = 'administrateur';
  protected $primaryKey = 'id_admin';
  public $timestamps = true;

  protected $guarded = ['id_admin', 'uuid', 'mdp', 'created_at', 'updated_at', 'deleted_at'];
}
