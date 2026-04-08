@extends('layouts.admin')
@section('title', 'Véhicules')
@section('page-title', 'Véhicules')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Véhicules</div>
    <div class="page-subtitle">{{ $vehicules->total() }} véhicule(s) enregistrés</div>
  </div>
  <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary"><i class="bi bi-people"></i> Via un client</a>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Immatriculation</th>
          <th>Marque / Modèle</th>
          <th>Année</th>
          <th>Propriétaire</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($vehicules as $v)
        <tr>
          <td style="font-weight:700; letter-spacing:1px; color:var(--accent)">{{ $v->immatriculation }}</td>
          <td>
            <div style="font-weight:600;">{{ $v->marque }}</div>
            <div style="font-size:0.78rem; color:var(--text-secondary);">{{ $v->modele }}</div>
          </td>
          <td>{{ $v->annee ?? '—' }}</td>
          <td>
            @if($v->client)
              <a href="{{ route('admin.clients.show',$v->client->id) }}" style="color:var(--text-primary);text-decoration:none;font-weight:500;">
                {{ $v->client->nom }} {{ $v->client->prenom ?? '' }}
              </a>
            @else — @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;justify-content:flex-end;">
              <a href="{{ route('admin.vehicules.show',$v->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-eye"></i></a>
              <a href="{{ route('admin.vehicules.edit',$v->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.vehicules.destroy',$v->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm btn-icon"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">
          <i class="bi bi-car-front" style="font-size:2rem;display:block;margin-bottom:8px;"></i> Aucun véhicule
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div style="margin-top:16px;">{{ $vehicules->links() }}</div>
@endsection