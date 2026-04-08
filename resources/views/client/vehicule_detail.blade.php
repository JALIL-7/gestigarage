@extends('layouts.client')
@section('title', $vehicule->immatriculation.' — Détail')

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
      <div>
        <div class="page-title" style="color:var(--accent);">{{ $vehicule->immatriculation }}</div>
        <div class="page-subtitle">{{ $vehicule->marque }} {{ $vehicule->modele }} {{ $vehicule->annee ? '('.$vehicule->annee.')' : '' }}</div>
      </div>
      <a href="{{ route('client.vehicules') }}" class="btn btn-outline"><i class="bi bi-arrow-left"></i> Retour</a>
    </div>

    <!-- Info véhicule -->
    <div class="card" style="margin-bottom:20px;">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-car-front-fill" style="color:var(--accent)"></i> Informations</div>
      </div>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;">
        <div><div style="font-size:0.72rem;color:#475569;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Immatriculation</div><div style="font-weight:700;font-size:1rem;color:var(--accent);">{{ $vehicule->immatriculation }}</div></div>
        <div><div style="font-size:0.72rem;color:#475569;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Marque</div><div style="font-weight:600;">{{ $vehicule->marque }}</div></div>
        <div><div style="font-size:0.72rem;color:#475569;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Modèle</div><div style="font-weight:600;">{{ $vehicule->modele }}</div></div>
        <div><div style="font-size:0.72rem;color:#475569;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:3px;">Année</div><div style="font-weight:600;">{{ $vehicule->annee ?? '—' }}</div></div>
      </div>
    </div>

    <!-- Réparations -->
    <div class="card">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-tools" style="color:var(--accent)"></i> Historique des réparations ({{ $vehicule->reparations->count() }})</div>
      </div>
      @if($vehicule->reparations->count())
      <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($vehicule->reparations->sortByDesc('created_at') as $r)
        <div style="background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:12px;padding:16px;position:relative;">
          @php $s = $r->statut; @endphp
          <div style="position:absolute;top:16px;right:16px;">
            @if($s === 'terminee')
              <span class="badge badge-success"><i class="bi bi-check-circle"></i> Terminée</span>
            @elseif($s === 'en cours')
              <span class="badge badge-info"><i class="bi bi-arrow-repeat"></i> En cours</span>
            @elseif($s === 'annulee')
              <span class="badge badge-danger"><i class="bi bi-x-circle"></i> Annulée</span>
            @else
              <span class="badge badge-warning"><i class="bi bi-clock"></i> En attente</span>
            @endif
          </div>

          <!-- Timeline statut -->
          @if($s === 'annulee')
            <div style="margin-bottom:14px; margin-right:90px; color:var(--danger); font-size:0.9rem; font-weight:600; display:flex; align-items:center; gap:8px;">
              <i class="bi bi-x-circle-fill"></i> Réparation annulée
            </div>
          @else
            <div class="status-steps" style="margin-bottom:14px; margin-right:90px;">
              <div class="step {{ in_array($s, ['en attente','en cours','terminee']) ? 'done' : '' }}">
                <div class="step-dot"><i class="bi bi-clock"></i></div>
                <div class="step-label">En attente</div>
              </div>
              <div class="step {{ in_array($s, ['en cours','terminee']) ? ($s === 'en cours' ? 'active' : 'done') : '' }}">
                <div class="step-dot"><i class="bi bi-arrow-repeat"></i></div>
                <div class="step-label">En cours</div>
              </div>
              <div class="step {{ $s === 'terminee' ? 'done' : '' }}">
                <div class="step-dot"><i class="bi bi-check2"></i></div>
                <div class="step-label">Terminée</div>
              </div>
            </div>
          @endif

          <div style="font-weight:600;margin-bottom:6px;">{{ $r->description_panne }}</div>
          @if($r->remarque)
            <div style="font-size:0.82rem;color:#64748b;margin-bottom:8px;font-style:italic;">{{ $r->remarque }}</div>
          @endif
          <div style="display:flex;gap:16px;flex-wrap:wrap;font-size:0.82rem;color:#64748b;margin-top:8px;">
            @if($r->date_debut)
              <span><i class="bi bi-calendar-event"></i> Début : {{ \Carbon\Carbon::parse($r->date_debut)->format('d/m/Y') }}</span>
            @endif
            @if($r->date_fin)
              <span><i class="bi bi-calendar-check"></i> Fin : {{ \Carbon\Carbon::parse($r->date_fin)->format('d/m/Y') }}</span>
            @endif
            <span style="margin-left:auto;font-weight:700;color:var(--text);">
              Total : {{ number_format($r->cout_main_oeuvre + $r->cout_pieces, 0, ',', ' ') }} F
            </span>
          </div>
          @if($r->facture)
          <div style="margin-top:10px;padding-top:10px;border-top:1px solid var(--border);display:flex;align-items:center;gap:8px;">
            <i class="bi bi-receipt" style="color:var(--success)"></i>
            <span style="font-size:0.82rem;">Facture N° {{ $r->facture->numero }}</span>
            <span class="badge {{ $r->facture->statut === 'payee' ? 'badge-success' : 'badge-danger' }}" style="font-size:0.7rem;">
              {{ $r->facture->statut === 'payee' ? 'Payée' : 'Impayée' }}
            </span>
          </div>
          @endif
        </div>
        @endforeach
      </div>
      @else
        <div style="text-align:center;padding:40px;color:var(--text-muted);">
          <i class="bi bi-tools" style="font-size:2.5rem;display:block;margin-bottom:12px;"></i>
          Aucune réparation pour ce véhicule.
        </div>
      @endif
    </div>
  </main>
</div>
@endsection
