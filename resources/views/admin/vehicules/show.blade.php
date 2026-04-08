@extends('layouts.admin')
@section('title', 'Véhicule '.$vehicule->immatriculation)
@section('page-title', 'Véhicules')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">{{ $vehicule->marque }} {{ $vehicule->modele }}</div>
    <div class="breadcrumb">
      <a href="{{ route('admin.vehicules.index') }}">Véhicules</a> <span>/</span> {{ $vehicule->immatriculation }}
    </div>
  </div>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.vehicules.edit',$vehicule->id) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Modifier</a>
    <a href="{{ route('admin.reparations.create',$vehicule->id) }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter réparation</a>
  </div>
</div>

<!-- Info véhicule -->
<div class="card" style="margin-bottom:20px;">
  <div class="card-header">
    <div class="card-title"><i class="bi bi-car-front-fill" style="color:var(--accent)"></i> Informations du véhicule</div>
    <span style="font-size:1.1rem;font-weight:800;letter-spacing:2px;color:var(--accent);">{{ $vehicule->immatriculation }}</span>
  </div>
  <div class="detail-grid">
    <div class="detail-item"><div class="detail-label">Marque</div><div class="detail-value">{{ $vehicule->marque }}</div></div>
    <div class="detail-item"><div class="detail-label">Modèle</div><div class="detail-value">{{ $vehicule->modele }}</div></div>
    <div class="detail-item"><div class="detail-label">Année</div><div class="detail-value">{{ $vehicule->annee ?? '—' }}</div></div>
    <div class="detail-item">
      <div class="detail-label">Propriétaire</div>
      <div class="detail-value">
        <a href="{{ route('admin.clients.show',$vehicule->client->id) }}" style="color:var(--accent);text-decoration:none;">
          {{ $vehicule->client->nom }} {{ $vehicule->client->prenom ?? '' }}
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Réparations -->
<div class="card" id="reparations">
  <div class="card-header">
    <div class="card-title"><i class="bi bi-tools" style="color:var(--accent)"></i> Réparations ({{ $vehicule->reparations->count() }})</div>
  </div>
  @if($vehicule->reparations->count())
  <div class="table-wrap">
    <table class="admin-table">
      <thead><tr><th>Description</th><th>Statut</th><th>Coût MO</th><th>Coût Pièces</th><th>Total</th><th>Facture</th><th></th></tr></thead>
      <tbody>
        @foreach($vehicule->reparations as $r)
        <tr>
          <td>{{ Str::limit($r->description_panne,50) }}</td>
          <td>
            @if($r->statut === 'terminee')
              <span class="badge badge-success"><i class="bi bi-check-circle"></i> Terminée</span>
            @elseif($r->statut === 'en cours')
              <span class="badge badge-info"><i class="bi bi-arrow-repeat"></i> En cours</span>
            @elseif($r->statut === 'annulee')
              <span class="badge badge-danger"><i class="bi bi-x-circle"></i> Annulée</span>
            @else
              <span class="badge badge-warning"><i class="bi bi-clock"></i> En attente</span>
            @endif
          </td>
          <td>{{ number_format($r->cout_main_oeuvre,0,',',' ') }} F</td>
          <td>{{ number_format($r->cout_pieces,0,',',' ') }} F</td>
          <td style="font-weight:600;">{{ number_format($r->cout_main_oeuvre + $r->cout_pieces,0,',',' ') }} F</td>
          <td>
            @if($r->facture)
              <a href="{{ route('admin.factures.show',$r->facture->id) }}" class="badge badge-success" style="text-decoration:none;"><i class="bi bi-receipt"></i> Générée</a>
            @else
              <a href="{{ route('admin.factures.create',$r->id) }}" class="badge badge-muted" style="text-decoration:none;"><i class="bi bi-plus"></i> Créer</a>
            @endif
          </td>
          <td><a href="{{ route('admin.reparations.show',$r->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-eye"></i></a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <div style="text-align:center;padding:40px;color:var(--text-muted);">
    <i class="bi bi-tools" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
    Aucune réparation.
    <br><a href="{{ route('admin.reparations.create',$vehicule->id) }}" class="btn btn-primary" style="margin-top:12px;">Ajouter</a>
  </div>
  @endif
</div>
@endsection