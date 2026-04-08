<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'contenu', 'sujet', 'statut', 'reponse_admin', 'repondu_le'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
