@extends('layouts.admin')
@section('title', 'Clients')
@section('page-title', 'Clients')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Clients</div>
    <div class="page-subtitle">{{ $clients->total() }} client(s) enregistrés</div>
  </div>
  <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
    <i class="bi bi-person-plus-fill"></i> Nouveau client
  </a>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Client</th>
          <th>Téléphone</th>
          <th>Email</th>
          <th>Adresse</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($clients as $client)
        <tr>
          <td>
            <div style="display:flex; align-items:center; gap:10px;">
              <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent),#ea580c);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.85rem;flex-shrink:0;">
                {{ strtoupper(substr($client->nom,0,1)) }}
              </div>
              <div>
                <div style="font-weight:600;">{{ $client->nom }} {{ $client->prenom }}</div>
                <div style="font-size:0.72rem;color:var(--text-muted);">ID #{{ $client->id }}</div>
              </div>
            </div>
          </td>
          <td>{{ $client->telephone ?? '—' }}</td>
          <td>{{ $client->email ?? '—' }}</td>
          <td style="color:var(--text-secondary);">{{ Str::limit($client->adresse ?? '—', 30) }}</td>
          <td>
            <div style="display:flex; gap:6px; justify-content:flex-end;">
              <a href="{{ route('admin.clients.show',$client->id) }}" class="btn btn-secondary btn-sm btn-icon" title="Voir"><i class="bi bi-eye"></i></a>
              <a href="{{ route('admin.clients.edit',$client->id) }}" class="btn btn-secondary btn-sm btn-icon" title="Modifier"><i class="bi bi-pencil"></i></a>
              <form action="{{ route('admin.clients.destroy',$client->id) }}" method="POST" onsubmit="return confirm('Supprimer ce client ?')" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm btn-icon" title="Supprimer"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center; padding:40px; color:var(--text-muted);">
          <i class="bi bi-people" style="font-size:2rem;display:block;margin-bottom:8px;"></i> Aucun client
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="margin-top:16px;">{{ $clients->links() }}</div>
@endsection