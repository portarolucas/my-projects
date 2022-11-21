<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{

    protected $table = 'voiture';
    protected $primaryKey = 'id_voiture';
    public $incrementing = true;
    public $timestamps = false;

    public function categorie(){
        return $this->belongsTo('Autoriko\Models\Categorie', 'id_categorie');
    }

    public function marque(){
        return $this->belongsTo('Autoriko\Models\Marque', 'id_marque');
    }

    public function reprsentation_voiture(){

        return $this->hasMany('Autoriko\Models\Representation_voiture', 'id_voiture');
    }

    public function photo_voiture(){
        return $this->hasMany('Autoriko\Models\Photo_voiture', 'id_voiture');
    }

    public function video_voiture(){
        return $this->hasMany('Autoriko\Models\Video_voiture', 'id_voiture');
    }

}
