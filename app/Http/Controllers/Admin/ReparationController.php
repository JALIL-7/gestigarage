<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reparation;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class ReparationController extends Controller
{
    public function index()
    {
        $reparations = Reparation::with('vehicule.client')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.reparations.index', compact('reparations'));
    }

    public function create($vehicule_id)
    {
        $vehicule = Vehicule::with('client')->findOrFail($vehicule_id);

        return view('admin.reparations.create', compact('vehicule'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'description_panne' => 'required',
            'remarque' => 'nullable',
            'cout_main_oeuvre' => 'nullable|numeric',
            'cout_pieces' => 'nullable|numeric',
            'statut' => 'nullable|in:en attente,en cours,terminee',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
        ]);

        Reparation::create(array_merge($data, [
            'date_debut' => $data['date_debut'] ?? now()->toDateString(),
        ]));

        return redirect()->route('admin.vehicules.show', $data['vehicule_id'])
            ->with('success', 'Réparation créée');
    }

    public function show($id)
    {
        $reparation = Reparation::with('vehicule.client', 'facture')->findOrFail($id);

        return view('admin.reparations.show', compact('reparation'));
    }

    public function update(Request $r, $id)
    {
        $reparation = Reparation::findOrFail($id);

        $data = $r->validate([
            'description_panne' => 'required',
            'remarque' => 'nullable',
            'cout_main_oeuvre' => 'nullable|numeric',
            'cout_pieces' => 'nullable|numeric',
            'statut' => 'required|in:en attente,en cours,terminee,annulee',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
        ]);

        $reparation->update($data);

        return back()->with('success', 'Réparation mise à jour avec succès.');
    }
}
