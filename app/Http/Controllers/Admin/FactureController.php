<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use App\Models\Reparation;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    protected function nextNumeroForReparation($reparation)
    {
        $count = Facture::where('reparation_id', $reparation->id)->count();

        return 'R'.$reparation->id.'-'.str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $factures = Facture::with('reparation.vehicule.client')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.factures.index', compact('factures'));
    }

    public function create($reparation_id)
    {
        $reparation = Reparation::with('vehicule.client')->findOrFail($reparation_id);

        return view('admin.factures.create', compact('reparation'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'reparation_id' => 'required|exists:reparations,id',
            'date_facture' => 'nullable|date',
        ]);

        $reparation = Reparation::findOrFail($data['reparation_id']);
        $numero = $this->nextNumeroForReparation($reparation);
        $montant = $reparation->cout_main_oeuvre + $reparation->cout_pieces;

        $facture = Facture::create([
            'reparation_id' => $reparation->id,
            'numero' => $numero,
            'montant_total' => $montant,
            'date_facture' => $data['date_facture'] ?? now()->toDateString(),
        ]);

        return redirect()->route('admin.factures.show', $facture->id)
            ->with('success', 'Facture créée');
    }

    public function show($id)
    {
        $facture = Facture::with('reparation.vehicule.client')->findOrFail($id);

        return view('admin.factures.show', compact('facture'));
    }

    public function pdf($id)
    {
        $facture = Facture::with('reparation.vehicule.client')->findOrFail($id);
        // Si barryvdh/laravel-dompdf est installé :
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.factures.pdf', compact('facture'));

            return $pdf->download('facture_'.$facture->numero.'.pdf');
        }

        // Sinon, afficher la vue PDF dans le navigateur
        return view('admin.factures.pdf', compact('facture'));
    }

    public function update(Request $request, $id)
    {
        $facture = Facture::findOrFail($id);
        $data = $request->validate(['statut' => 'required|in:payee,impayee']);
        $facture->update($data);

        return redirect()->route('admin.factures.show', $facture->id)
            ->with('success', 'Statut mis à jour');
    }

    public function destroy($id)
    {
        Facture::findOrFail($id)->delete();

        return back()->with('success', 'Facture supprimée');
    }
}
