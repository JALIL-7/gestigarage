@extends('layouts.admin')
@section('title', 'Factures')
@section('page-title', 'Factures')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Factures</div>
    <div class="page-subtitle">{{ $factures->total() }} facture(s)</div>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Numéro</th>
          <th>Client</th>
          <th>Véhicule</th>
          <th>Date</th>
          <th>Montant</th>
          <th>Statut</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($factures as $f)
        <tr>
          <td style="font-weight:700;color:var(--accent);">{{ $f->numero }}</td>
          <td>{{ $f->reparation->vehicule->client->nom ?? '—' }}</td>
          <td>{{ $f->reparation->vehicule->immatriculation ?? '—' }}</td>
          <td style="color:var(--text-secondary);">{{ $f->date_facture }}</td>
          <td style="font-weight:600;">{{ number_format($f->montant_total,0,',',' ') }} F</td>
          <td>
            <span class="badge {{ $f->statut === 'payee' ? 'badge-success' : 'badge-danger' }}">
              {{ $f->statut === 'payee' ? 'Payée' : 'Impayée' }}
            </span>
          </td>
          <td>
            <div style="display:flex;gap:6px;justify-content:flex-end;">
              <a href="{{ route('admin.factures.show',$f->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-eye"></i></a>
              <a href="{{ route('admin.factures.pdf',$f->id) }}" class="btn btn-secondary btn-sm btn-icon" title="PDF"><i class="bi bi-download"></i></a>
              <form action="{{ route('admin.factures.destroy',$f->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm btn-icon"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">
          <i class="bi bi-receipt" style="font-size:2rem;display:block;margin-bottom:8px;"></i> Aucune facture
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div style="margin-top:16px;">{{ $factures->links() }}</div>
@endsection
