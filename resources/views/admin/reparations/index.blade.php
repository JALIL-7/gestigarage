@extends('layouts.admin')
@section('title', 'Réparations')
@section('page-title', 'Réparations')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Réparations</div>
    <div class="page-subtitle">{{ $reparations->total() }} réparation(s)</div>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Véhicule</th>
          <th>Client</th>
          <th>Description</th>
          <th>Statut</th>
          <th>Total</th>
          <th>Date début</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($reparations as $r)
        <tr>
          <td style="color:var(--text-muted);font-size:0.8rem;">#{{ $r->id }}</td>
          <td style="font-weight:700;color:var(--accent);">{{ $r->vehicule->immatriculation ?? '—' }}</td>
          <td>{{ $r->vehicule->client->nom ?? '—' }}</td>
          <td style="color:var(--text-secondary);">{{ Str::limit($r->description_panne,50) }}</td>
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
          <td style="font-weight:600;">{{ number_format($r->cout_main_oeuvre + $r->cout_pieces, 0, ',', ' ') }} F</td>
          <td style="color:var(--text-secondary);font-size:0.82rem;">{{ $r->date_debut ?? '—' }}</td>
          <td><a href="{{ route('admin.reparations.show',$r->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-eye"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--text-muted);">
          <i class="bi bi-tools" style="font-size:2rem;display:block;margin-bottom:8px;"></i> Aucune réparation
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div style="margin-top:16px;">{{ $reparations->links() }}</div>
@endsection
