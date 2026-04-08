@extends('layouts.admin')
@section('title', 'Fiche client — '.$client->nom)
@section('page-title', 'Clients')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">{{ $client->nom }} {{ $client->prenom ?? '' }}</div>
    <div class="breadcrumb"><a href="{{ route('admin.clients.index') }}">Clients</a> <span>/</span> Fiche</div>
  </div>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.clients.edit',$client->id) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Modifier</a>
    <a href="{{ route('admin.vehicules.createForClient',$client->id) }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter véhicule</a>
  </div>
</div>

<!-- Info client -->
<div class="card" style="margin-bottom:20px;">
  <div class="card-header">
    <div class="card-title"><i class="bi bi-person-fill" style="color:var(--accent)"></i> Informations client</div>
    @if($client->email)
      <span class="badge badge-{{ $client->password ? 'success' : 'muted' }}">
        <i class="bi bi-{{ $client->password ? 'shield-check' : 'shield-x' }}"></i>
        Portail {{ $client->password ? 'activé' : 'désactivé' }}
      </span>
    @endif
  </div>
  <div class="detail-grid">
    <div class="detail-item"><div class="detail-label">Nom complet</div><div class="detail-value">{{ $client->nom }} {{ $client->prenom ?? '' }}</div></div>
    <div class="detail-item"><div class="detail-label">Téléphone</div><div class="detail-value">{{ $client->telephone ?? '—' }}</div></div>
    <div class="detail-item"><div class="detail-label">Email</div><div class="detail-value">{{ $client->email ?? '—' }}</div></div>
    <div class="detail-item"><div class="detail-label">Adresse</div><div class="detail-value">{{ $client->adresse ?? '—' }}</div></div>
    <div class="detail-item"><div class="detail-label">Client depuis</div><div class="detail-value">{{ $client->created_at->format('d/m/Y') }}</div></div>
    <div class="detail-item"><div class="detail-label">Nb. véhicules</div><div class="detail-value">{{ $client->vehicules->count() }}</div></div>
  </div>
</div>

<!-- Véhicules -->
<div class="card">
  <div class="card-header">
    <div class="card-title"><i class="bi bi-car-front-fill" style="color:var(--accent)"></i> Véhicules du client ({{ $client->vehicules->count() }})</div>
  </div>
  @if($client->vehicules->count())
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr><th>Immatriculation</th><th>Marque / Modèle</th><th>Année</th><th>Réparations</th><th></th></tr>
      </thead>
      <tbody>
        @foreach($client->vehicules as $vehicule)
        <tr>
          <td style="font-weight:700;letter-spacing:1px;">{{ $vehicule->immatriculation }}</td>
          <td>{{ $vehicule->marque }} {{ $vehicule->modele }}</td>
          <td>{{ $vehicule->annee ?? '—' }}</td>
          <td>
            @php
              $enCours = $vehicule->reparations->where('statut','en cours')->count();
              $total = $vehicule->reparations->count();
            @endphp
            <span class="badge {{ $enCours > 0 ? 'badge-info' : 'badge-muted' }}">
              {{ $enCours > 0 ? $enCours.' en cours' : $total.' total' }}
            </span>
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.vehicules.show',$vehicule->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-eye"></i></a>
              <a href="{{ route('admin.vehicules.edit',$vehicule->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.vehicules.destroy',$vehicule->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm btn-icon"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <div style="text-align:center; padding:40px; color:var(--text-muted);">
    <i class="bi bi-car-front" style="font-size:2.5rem;display:block;margin-bottom:12px;"></i>
    Aucun véhicule enregistré pour ce client.
    <br><a href="{{ route('admin.vehicules.createForClient',$client->id) }}" class="btn btn-primary" style="margin-top:12px;">Ajouter un véhicule</a>
  </div>
  @endif
</div>
@endsection
