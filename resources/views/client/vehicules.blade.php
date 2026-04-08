@extends('layouts.client')
@section('title', 'Mes véhicules')

@section('content')
<div class="client-layout">
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

  <main class="client-main">
    <div class="page-header">
      <div><div class="page-title">Mes véhicules</div><div class="page-subtitle">{{ $client->vehicules->count() }} véhicule(s) enregistré(s)</div></div>
    </div>

    @if($client->vehicules->count())
      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">
        @foreach($client->vehicules as $v)
        <div class="card" style="transition:all 0.25s;" onmouseover="this.style.borderColor='rgba(249,115,22,0.4)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;">
            <div style="width:54px;height:54px;background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:var(--accent);"><i class="bi bi-car-front-fill"></i></div>
            <div>
              <div style="font-weight:800;font-size:1.1rem;color:var(--accent);letter-spacing:1px;">{{ $v->immatriculation }}</div>
              <div style="font-size:0.82rem;color:#64748b;">{{ $v->marque }} {{ $v->modele }}</div>
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;font-size:0.82rem;">
            <div>
              <div style="color:#475569;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Marque</div>
              <div style="font-weight:600;">{{ $v->marque }}</div>
            </div>
            <div>
              <div style="color:#475569;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Modèle</div>
              <div style="font-weight:600;">{{ $v->modele }}</div>
            </div>
            <div>
              <div style="color:#475569;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Année</div>
              <div style="font-weight:600;">{{ $v->annee ?? '—' }}</div>
            </div>
            <div>
              <div style="color:#475569;font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Réparations</div>
              <div style="font-weight:600;">{{ $v->reparations->count() }}</div>
            </div>
          </div>

          @php
            $enCours = $v->reparations->where('statut','en cours')->count();
            $enAttente = $v->reparations->where('statut','en attente')->count();
          @endphp
          @if($enCours > 0)
            <div style="background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.25);border-radius:8px;padding:8px 12px;margin-bottom:12px;font-size:0.81rem;color:#a5b4fc;display:flex;align-items:center;gap:6px;">
              <i class="bi bi-arrow-repeat"></i> {{ $enCours }} réparation(s) en cours
            </div>
          @elseif($enAttente > 0)
            <div style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);border-radius:8px;padding:8px 12px;margin-bottom:12px;font-size:0.81rem;color:#fcd34d;display:flex;align-items:center;gap:6px;">
              <i class="bi bi-clock"></i> {{ $enAttente }} réparation(s) en attente
            </div>
          @endif

          <a href="{{ route('client.vehicules.detail', $v->id) }}" class="btn btn-outline" style="width:100%;justify-content:center;">
            <i class="bi bi-eye"></i> Voir les détails
          </a>
        </div>
        @endforeach
      </div>
    @else
      <div class="card" style="text-align:center;padding:60px;color:var(--text-muted);">
        <i class="bi bi-car-front" style="font-size:3rem;display:block;margin-bottom:14px;color:#1e2535;"></i>
        <div style="font-size:1.1rem;font-weight:600;margin-bottom:8px;">Aucun véhicule enregistré</div>
        <div style="font-size:0.85rem;">Contactez notre équipe pour faire enregistrer votre véhicule dans notre système.</div>
        <a href="{{ route('client.messages') }}" class="btn btn-primary" style="margin-top:20px;">
          <i class="bi bi-chat-dots-fill"></i> Contacter le garage
        </a>
      </div>
    @endif
  </main>
</div>
@endsection
