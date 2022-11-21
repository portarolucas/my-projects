<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    
    protected $table = 'achat';
    protected $primaryKey = 'id_achat';
    public $timestamps = false;

    protected $filiable = [];
}