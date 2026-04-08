<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function createForClient($client_id)
    {
        $client = Client::findOrFail($client_id);

        return view('admin.vehicules.create', compact('client'));
    }

    public function index()
    {
        $vehicules = Vehicule::with('client')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.vehicules.index', compact('vehicules'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'client_id' => 'required|exists:clients,id',
            'marque' => 'required',
            'modele' => 'required',
            'annee' => 'nullable|integer',
            'immatriculation' => 'required|unique:vehicules,immatriculation',
        ]);

        Vehicule::create($data);

        return back()->with('success', 'Véhicule ajouté');
    }

    public function show($id)
    {
        $vehicule = Vehicule::with('client', 'reparations.facture')->findOrFail($id);

        return view('admin.vehicules.show', compact('vehicule'));
    }

    public function destroy($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        $vehicule->delete();

        return back()->with('success', 'Véhicule supprimé');
    }

    public function edit($id)
    {
        $vehicule = Vehicule::findOrFail($id);

        return view('admin.vehicules.edit', compact('vehicule'));
    }

    public function update(Request $r, $id)
    {
        $data = $r->validate([
            'marque' => 'required',
            'modele' => 'required',
            'annee' => 'nullable|integer',
            'immatriculation' => 'required|unique:vehicules,immatriculation,'.$id,
        ]);

        $vehicule = Vehicule::findOrFail($id);
        $vehicule->update($data);

        return redirect()->route('admin.vehicules.show', $vehicule->id)
            ->with('success', 'Véhicule mis à jour');
    }
}
