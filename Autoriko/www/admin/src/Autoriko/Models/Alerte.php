<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    
    protected $table = 'alerte';
    protected $primaryKey = 'id_alerte';
    public $timestamps = false;

}