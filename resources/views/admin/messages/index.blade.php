@extends('layouts.admin')
@section('title', 'Messages clients')
@section('page-title', 'Messages')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Messages clients</div>
    <div class="page-subtitle">
      {{ $messages->total() }} message(s) —
      <span style="color:var(--danger);">{{ \App\Models\Message::where('statut','non_lu')->count() }} non lu(s)</span>
    </div>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Client</th>
          <th>Sujet</th>
          <th>Date</th>
          <th>Statut</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($messages as $msg)
        <tr style="{{ $msg->statut === 'non_lu' ? 'background:rgba(249,115,22,0.04)' : '' }}">
          <td>
            <div style="font-weight:600;">{{ $msg->client->nom ?? '—' }}</div>
            <div style="font-size:0.75rem;color:var(--text-secondary);">{{ $msg->client->email ?? '' }}</div>
          </td>
          <td style="{{ $msg->statut==='non_lu' ? 'font-weight:700;' : '' }}">
            {{ $msg->sujet }}
          </td>
          <td style="color:var(--text-secondary);font-size:0.82rem;">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
          <td>
            @if($msg->statut === 'non_lu')
              <span class="badge badge-warning"><i class="bi bi-envelope-fill"></i> Non lu</span>
            @elseif($msg->statut === 'lu')
              <span class="badge badge-muted"><i class="bi bi-envelope-open"></i> Lu</span>
            @else
              <span class="badge badge-success"><i class="bi bi-reply-fill"></i> Répondu</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;justify-content:flex-end;">
              <a href="{{ route('admin.messages.show',$msg->id) }}" class="btn btn-secondary btn-sm btn-icon"><i class="bi bi-eye"></i></a>
              <form action="{{ route('admin.messages.destroy',$msg->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm btn-icon"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">
          <i class="bi bi-chat-dots" style="font-size:2rem;display:block;margin-bottom:8px;"></i> Aucun message
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div style="margin-top:16px;">{{ $messages->links() }}</div>
@endsection
