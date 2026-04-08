@extends('layouts.client')
@section('title', 'Mes réparations')

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
        <div class="page-title">Mes réparations</div>
        <div class="page-subtitle">Tous vos travaux, tous véhicules confondus</div>
      </div>
    </div>

    @if($reparations->count())
    <div class="card">
      <div style="overflow-x:auto;">
        <table class="tbl">
          <thead>
            <tr>
              <th>Véhicule</th>
              <th>Description</th>
              <th>Statut</th>
              <th>Date début</th>
              <th>Date fin</th>
              <th>Total</th>
              <th>Facture</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reparations as $r)
            <tr>
              <td>
                <a href="{{ route('client.vehicules.detail', $r->vehicule->id) }}" style="color:var(--accent);font-weight:700;text-decoration:none;letter-spacing:1px;">
                  {{ $r->vehicule->immatriculation ?? '—' }}
                </a>
                <div style="font-size:0.75rem;color:#64748b;">{{ $r->vehicule->marque ?? '' }} {{ $r->vehicule->modele ?? '' }}</div>
              </td>
              <td style="max-width:220px;">{{ Str::limit($r->description_panne, 60) }}</td>
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
              <td style="color:#64748b;font-size:0.82rem;">{{ $r->date_debut ? \Carbon\Carbon::parse($r->date_debut)->format('d/m/Y') : '—' }}</td>
              <td style="color:#64748b;font-size:0.82rem;">{{ $r->date_fin ? \Carbon\Carbon::parse($r->date_fin)->format('d/m/Y') : '—' }}</td>
              <td style="font-weight:700;">{{ number_format($r->cout_main_oeuvre + $r->cout_pieces, 0, ',', ' ') }} F</td>
              <td>
                @if($r->facture)
                  <span class="badge {{ $r->facture->statut === 'payee' ? 'badge-success' : 'badge-danger' }}">
                    {{ $r->facture->statut === 'payee' ? 'Payée' : 'Impayée' }}
                  </span>
                @else
                  <span class="badge badge-muted">—</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @else
      <div class="card" style="text-align:center;padding:60px;color:var(--text-muted);">
        <i class="bi bi-tools" style="font-size:3rem;display:block;margin-bottom:14px;color:#1e2535;"></i>
        <div style="font-size:1.1rem;font-weight:600;margin-bottom:8px;">Aucune réparation</div>
        <div style="font-size:0.85rem;">Aucune réparation n'a encore été enregistrée pour vos véhicules.</div>
      </div>
    @endif
  </main>
</div>
@endsection
