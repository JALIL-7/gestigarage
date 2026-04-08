@extends('layouts.admin')
@section('title', 'Facture '.$facture->numero)
@section('page-title', 'Factures')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Facture N° {{ $facture->numero }}</div>
    <div class="breadcrumb">
      <a href="{{ route('admin.factures.index') }}">Factures</a> <span>/</span> {{ $facture->numero }}
    </div>
  </div>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.factures.pdf',$facture->id) }}" class="btn btn-secondary"><i class="bi bi-download"></i> Télécharger PDF</a>
    <form action="{{ route('admin.factures.update',$facture->id) }}" method="POST" style="display:inline">
      @csrf @method('PUT')
      <input type="hidden" name="statut" value="{{ $facture->statut === 'payee' ? 'impayee' : 'payee' }}">
      <button class="btn btn-{{ $facture->statut === 'payee' ? 'danger' : 'success' }}">
        <i class="bi bi-{{ $facture->statut === 'payee' ? 'x-circle' : 'check-circle' }}"></i>
        @if($facture->statut === 'payee') Marquer impayée @else Marquer payée @endif
      </button>
    </form>
  </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
  <!-- Détails facture -->
  <div class="card">
    <div class="card-header">
      <div class="card-title"><i class="bi bi-receipt" style="color:var(--accent)"></i> Détails de la facture</div>
      <span class="badge {{ $facture->statut === 'payee' ? 'badge-success' : 'badge-danger' }}" style="font-size:0.85rem; padding:5px 14px;">
        @if($facture->statut === 'payee')
          <i class="bi bi-check-circle-fill"></i> Payée
        @else
          <i class="bi bi-x-circle-fill"></i> Impayée
        @endif
      </span>
    </div>
    <div class="detail-grid" style="margin-bottom:20px;">
      <div class="detail-item"><div class="detail-label">Numéro</div><div class="detail-value" style="font-weight:700;font-size:1rem;">{{ $facture->numero }}</div></div>
      <div class="detail-item"><div class="detail-label">Date</div><div class="detail-value">{{ $facture->date_facture }}</div></div>
      <div class="detail-item">
        <div class="detail-label">Client</div>
        <div class="detail-value">
          <a href="{{ route('admin.clients.show',$facture->reparation->vehicule->client->id) }}" style="color:var(--accent);text-decoration:none;">
            {{ $facture->reparation->vehicule->client->nom }}
          </a>
        </div>
      </div>
      <div class="detail-item">
        <div class="detail-label">Véhicule</div>
        <div class="detail-value">
          <a href="{{ route('admin.vehicules.show',$facture->reparation->vehicule->id) }}" style="color:var(--text-primary);text-decoration:none;">
            {{ $facture->reparation->vehicule->immatriculation }}
          </a>
        </div>
      </div>
    </div>

    <div style="padding:16px;background:rgba(255,255,255,0.03);border-radius:8px;">
      <div class="detail-label" style="margin-bottom:8px;">Description réparation</div>
      <p style="color:var(--text-primary);line-height:1.6;">{{ $facture->reparation->description_panne }}</p>
    </div>
  </div>

  <!-- Montants -->
  <div class="card" style="align-self:start;">
    <div class="card-header"><div class="card-title"><i class="bi bi-cash-coin" style="color:var(--accent)"></i> Montants</div></div>
    <div style="display:flex;flex-direction:column;gap:14px;">
      <div style="display:flex;justify-content:space-between;font-size:0.85rem;">
        <span style="color:var(--text-secondary);">Main-d'œuvre</span>
        <span style="font-weight:600;">{{ number_format($facture->reparation->cout_main_oeuvre,0,',',' ') }} F</span>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:0.85rem;">
        <span style="color:var(--text-secondary);">Pièces</span>
        <span style="font-weight:600;">{{ number_format($facture->reparation->cout_pieces,0,',',' ') }} F</span>
      </div>
      <div style="height:1px;background:var(--border);"></div>
      <div style="display:flex;justify-content:space-between;">
        <span style="font-weight:700;font-size:1rem;">Total TTC</span>
        <span style="font-weight:800;font-size:1.3rem;color:var(--accent);">
          {{ number_format($facture->montant_total,0,',',' ') }} F
        </span>
      </div>
    </div>
  </div>
</div>
@endsection