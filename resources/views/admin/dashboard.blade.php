@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Tableau de bord</div>
    <div class="page-subtitle">Vue d'ensemble de votre garage</div>
  </div>
  <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Nouveau client
  </a>
</div>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon orange"><i class="bi bi-wrench-adjustable"></i></div>
    <div>
      <div class="stat-val">{{ $totalReparations }}</div>
      <div class="stat-label">Total réparations</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue"><i class="bi bi-arrow-repeat"></i></div>
    <div>
      <div class="stat-val">{{ $enCours }}</div>
      <div class="stat-label">En cours</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="bi bi-check2-circle"></i></div>
    <div>
      <div class="stat-val">{{ $terminees }}</div>
      <div class="stat-label">Terminées</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple"><i class="bi bi-cash-coin"></i></div>
    <div>
      <div class="stat-val" style="font-size:1.2rem;">{{ number_format($revenusMois,0,',',' ') }} F</div>
      <div class="stat-label">Revenus ce mois</div>
    </div>
  </div>
</div>

<!-- Tables -->
<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
  <!-- Derniers clients -->
  <div class="card">
    <div class="card-header">
      <div class="card-title"><i class="bi bi-people-fill" style="color:var(--accent)"></i> Derniers clients</div>
      <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary btn-sm">Voir tous</a>
    </div>
    <div class="table-wrap">
      <table class="admin-table">
        <thead><tr><th>Nom</th><th>Téléphone</th><th></th></tr></thead>
        <tbody>
          @foreach($dernierClients as $c)
          <tr>
            <td>
              <div style="font-weight:600;">{{ $c->nom }} {{ $c->prenom ?? '' }}</div>
              <div style="font-size:0.75rem; color:var(--text-secondary);">{{ $c->email ?? '—' }}</div>
            </td>
            <td>{{ $c->telephone ?? '—' }}</td>
            <td><a href="{{ route('admin.clients.show',$c->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-eye"></i></a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Dernières réparations -->
  <div class="card">
    <div class="card-header">
      <div class="card-title"><i class="bi bi-tools" style="color:var(--accent)"></i> Dernières réparations</div>
      <a href="{{ route('admin.reparations.index') }}" class="btn btn-secondary btn-sm">Voir toutes</a>
    </div>
    <div class="table-wrap">
      <table class="admin-table">
        <thead><tr><th>Véhicule</th><th>Panne</th><th>Statut</th></tr></thead>
        <tbody>
          @foreach($dernieresReparations as $r)
          <tr>
            <td style="font-weight:600;">{{ $r->vehicule->immatriculation ?? '—' }}</td>
            <td style="color:var(--text-secondary);">{{ Str::limit($r->description_panne,40) }}</td>
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
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection