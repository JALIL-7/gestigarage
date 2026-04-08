<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected function client()
    {
        return Auth::guard('client')->user();
    }

    public function index()
    {
        $client = $this->client()->load('vehicules.reparations.facture', 'messages');

        $totalVehicules = $client->vehicules->count();
        $reparationsEnCours = $client->vehicules->flatMap->reparations
            ->where('statut', 'en cours')->count();
        $reparationsTerminees = $client->vehicules->flatMap->reparations
            ->where('statut', 'terminee')->count();
        $messagesNonLus = $client->messages->where('statut', 'repondu')->where('client_read', false)->count();

        return view('client.dashboard', compact(
            'client', 'totalVehicules', 'reparationsEnCours', 'reparationsTerminees', 'messagesNonLus'
        ));
    }

    public function vehicules()
    {
        $client = $this->client()->load('vehicules.reparations');

        return view('client.vehicules', compact('client'));
    }

    public function vehiculeDetail($id)
    {
        $client = $this->client();
        $vehicule = $client->vehicules()->with('reparations.facture')->findOrFail($id);

        return view('client.vehicule_detail', compact('client', 'vehicule'));
    }

    public function reparations()
    {
        $client = $this->client()->load('vehicules.reparations.facture');
        $reparations = $client->vehicules->flatMap(function ($v) {
            return $v->reparations->map(function ($r) use ($v) {
                $r->vehicule = $v;

                return $r;
            });
        })->sortByDesc('created_at');

        return view('client.reparations', compact('client', 'reparations'));
    }

    public function messages()
    {
        $client = $this->client();
        $messages = $client->messages()->orderBy('created_at', 'desc')->get();

        Message::where('client_id', $client->id)
            ->where('statut', 'repondu')
            ->where('client_read', false)
            ->update(['client_read' => true]);

        return view('client.messages', compact('client', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'sujet' => 'required|string|max:150',
            'contenu' => 'required|string|max:2000',
        ]);

        $data['client_id'] = $this->client()->id;

        Message::create($data);

        return back()->with('success', 'Votre message a été envoyé à l\'équipe.');
    }
}
