<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('nom')->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'nom' => 'required',
            'prenom' => 'nullable',
            'telephone' => 'nullable',
            'email' => 'nullable|email|unique:clients,email',
            'adresse' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        Client::create($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client ajouté');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $r, $id)
    {
        $data = $r->validate([
            'nom' => 'required',
            'prenom' => 'nullable',
            'telephone' => 'nullable',
            'email' => 'nullable|email|unique:clients,email,'.$id,
            'adresse' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $client = Client::findOrFail($id);
        $client->update($data);

        return redirect()->route('admin.clients.show', $id)->with('success', 'Client mis à jour');
    }

    public function destroy($id)
    {
        Client::findOrFail($id)->delete();

        return back()->with('success', 'Client supprimé');
    }

    public function show($id)
    {
        $client = Client::with('vehicules.reparations.facture')->findOrFail($id);

        return view('admin.clients.show', compact('client'));
    }
}
