<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    protected $table = 'administrateur';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;
    
}
