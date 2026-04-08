<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicule_id', 'description_panne', 'remarque', 'cout_main_oeuvre', 'cout_pieces', 'statut', 'date_debut', 'date_fin',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    public function getTotalAttribute()
    {
        return $this->cout_main_oeuvre + $this->cout_pieces;
    }
}
