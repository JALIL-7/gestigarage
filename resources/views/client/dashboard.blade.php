@extends('layouts.client')
@section('title', 'Tableau de bord')

@section('content')
<div class="client-layout">

  <!-- Sidebar -->
  <aside class="client-sidebar">
    <a href="{{ route('client.dashboard') }}" class="cs-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2-fill"></i> Tableau de bord
    </a>
    <a href="{{ route('client.vehicules') }}" class="cs-item {{ request()->routeIs('client.vehicules*') ? 'active' : '' }}">
      <i class="bi bi-car-front-fill"></i> Mes véhicules
    </a>
    <a href="{{ route('client.reparations') }}" class="cs-item {{ request()->routeIs('client.reparations') ? 'active' : '' }}">
      <i class="bi bi-tools"></i> Réparations
    </a>
    <a href="{{ route('client.messages') }}" class="cs-item {{ request()->routeIs('client.messages') ? 'active' : '' }}">
      <i class="bi bi-chat-dots-fill"></i> Mes messages
      @php $rep = $client->messages->where('statut','repondu')->where('client_read', false)->count(); @endphp
      @if($rep > 0)
        <span style="margin-left:auto;background:var(--accent);color:white;font-size:0.65rem;font-weight:700;padding:2px 6px;border-radius:20px;">{{ $rep }}</span>
      @endif
    </a>
  </aside>

  <!-- Main -->
  <main class="client-main">
    @if(session('success'))
      <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <div class="page-header">
      <div>
        <div class="page-title">Bonjour, {{ $client->nom }}</div>
        <div class="page-subtitle">Voici un résumé de votre espace client</div>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon si-orange"><i class="bi bi-car-front-fill"></i></div>
        <div class="stat-val">{{ $totalVehicules }}</div>
        <div class="stat-label">Véhicule(s)</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-blue"><i class="bi bi-arrow-repeat"></i></div>
        <div class="stat-val">{{ $reparationsEnCours }}</div>
        <div class="stat-label">En cours</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-green"><i class="bi bi-check2-circle"></i></div>
        <div class="stat-val">{{ $reparationsTerminees }}</div>
        <div class="stat-label">Terminées</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon si-warn"><i class="bi bi-reply-fill"></i></div>
        <div class="stat-val">{{ $messagesNonLus }}</div>
        <div class="stat-label">Réponse(s) reçue(s)</div>
      </div>
    </div>

    <!-- Dernières réparations -->
    <div class="card" style="margin-bottom:20px;">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-tools" style="color:var(--accent)"></i> Mes dernières réparations</div>
        <a href="{{ route('client.reparations') }}" class="btn btn-outline btn-sm">Voir tout</a>
      </div>
      @php
        $allRep = $client->vehicules->flatMap->reparations->sortByDesc('created_at')->take(5);
      @endphp
      @if($allRep->count())
      <div style="overflow-x:auto;">
        <table class="tbl">
          <thead><tr><th>Véhicule</th><th>Panne</th><th>Statut</th><th>Date</th></tr></thead>
          <tbody>
            @foreach($allRep as $r)
            <tr>
              <td style="font-weight:600;color:var(--accent);">
                {{ $r->vehicule->immatriculation ?? '—' }}
              </td>
              <td style="color:#94a3b8;">{{ Str::limit($r->description_panne,50) }}</td>
              <td>
                @php $s = $r->statut; @endphp
                @if($s === 'terminee')
                  <span class="badge badge-success"><i class="bi bi-check-circle"></i> Terminée</span>
                @elseif($s === 'en cours')
                  <span class="badge badge-info"><i class="bi bi-arrow-repeat"></i> En cours</span>
                @elseif($s === 'annulee')
                  <span class="badge badge-danger"><i class="bi bi-x-circle"></i> Annulée</span>
                @else
                  <span class="badge badge-warning"><i class="bi bi-clock"></i> En attente</span>
                @endif
              </td>
              <td style="color:#64748b; font-size:0.8rem;">{{ $r->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
        <div style="text-align:center;padding:30px;color:var(--text-muted);">
          <i class="bi bi-tools" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
          Aucune réparation pour le moment.
        </div>
      @endif
    </div>

    <!-- Véhicules rapides -->
    <div class="card">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-car-front-fill" style="color:var(--accent)"></i> Mes véhicules</div>
        <a href="{{ route('client.vehicules') }}" class="btn btn-outline btn-sm">Voir tout</a>
      </div>
      @if($client->vehicules->count())
      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:14px;">
        @foreach($client->vehicules as $v)
        <a href="{{ route('client.vehicules.detail', $v->id) }}" style="text-decoration:none;">
          <div style="background: rgba(249,115,22,0.06); border: 1px solid rgba(249,115,22,0.15); border-radius:12px; padding:16px; transition:all 0.2s;" onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='rgba(249,115,22,0.15)'">
            <div style="font-size:1.8rem;margin-bottom:8px;color:var(--accent);"><i class="bi bi-car-front-fill"></i></div>
            <div style="font-weight:700; color:var(--accent); letter-spacing:1px; font-size:0.9rem;">{{ $v->immatriculation }}</div>
            <div style="font-size:0.82rem; color:#94a3b8; margin-top:4px;">{{ $v->marque }} {{ $v->modele }} {{ $v->annee ? '('.$v->annee.')' : '' }}</div>
            <div style="margin-top:8px; font-size:0.75rem; color:#64748b;">{{ $v->reparations->count() }} réparation(s)</div>
          </div>
        </a>
        @endforeach
      </div>
      @else
        <div style="text-align:center;padding:30px;color:var(--text-muted);">
          <i class="bi bi-car-front" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
          Aucun véhicule enregistré.
          <br><span style="font-size:0.82rem;">Contactez votre garage pour faire ajouter votre véhicule.</span>
        </div>
      @endif
    </div>
  </main>
</div>
@endsection
