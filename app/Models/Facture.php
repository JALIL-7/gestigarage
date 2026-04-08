<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = ['reparation_id', 'numero', 'montant_total', 'date_facture', 'statut'];

    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }
}
