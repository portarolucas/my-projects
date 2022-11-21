<?php
namespace Autoriko\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversation';
    protected $primaryKey = 'id_conversation';
    public $timestamps = true;

    protected $guarded = ['id_conversation', 'uuid', 'id_admin', 'id_utilisateur', 'created_at', 'updated_at', 'deleted_at'];

    public function administrateur(){
        return $this->belongsTo('Autoriko\Models\Administrateur', 'id_admin');
    }

    public function utilisateur(){
        return $this->belongsTo('Autoriko\Models\Utilisateur', 'id_utilisateur');
    }

    public function messages(){
        return $this->HasMany('Autoriko\Models\Message', 'id_conversation');
    }
} 