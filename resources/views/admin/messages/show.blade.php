@extends('layouts.admin')
@section('title', 'Message — '.$message->sujet)
@section('page-title', 'Messages')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">{{ $message->sujet }}</div>
    <div class="breadcrumb"><a href="{{ route('admin.messages.index') }}">Messages</a> <span>/</span> Détail</div>
  </div>
  <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
  <!-- Message -->
  <div>
    <div class="card" style="margin-bottom:16px;">
      <div class="card-header">
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--accent),#ea580c);display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">
            {{ strtoupper(substr($message->client->nom ?? 'C',0,1)) }}
          </div>
          <div>
            <div style="font-weight:600;">{{ $message->client->nom ?? '—' }}</div>
            <div style="font-size:0.75rem;color:var(--text-secondary);">{{ $message->created_at->format('d/m/Y à H:i') }}</div>
          </div>
        </div>
        @if($message->statut === 'repondu')
          <span class="badge badge-success"><i class="bi bi-reply-fill"></i> Répondu</span>
        @elseif($message->statut === 'lu')
          <span class="badge badge-muted">Lu</span>
        @endif
      </div>
      <p style="line-height:1.8;color:var(--text-primary);">{{ $message->contenu }}</p>
    </div>

    @if($message->reponse_admin)
    <div class="card" style="border-color:rgba(16,185,129,0.3); margin-bottom:16px;">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-reply-fill" style="color:var(--success)"></i> Votre réponse</div>
        <span style="font-size:0.75rem;color:var(--text-secondary);">{{ $message->repondu_le ? \Carbon\Carbon::parse($message->repondu_le)->format('d/m/Y H:i') : '' }}</span>
      </div>
      <p style="line-height:1.8;color:var(--text-secondary);">{{ $message->reponse_admin }}</p>
    </div>
    @endif

    <!-- Formulaire réponse -->
    <div class="card">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-chat-dots-fill" style="color:var(--accent)"></i> Répondre au client</div>
      </div>
      <form action="{{ route('admin.messages.repondre',$message->id) }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Votre réponse</label>
          <textarea name="reponse_admin" class="form-control" rows="5" required placeholder="Saisissez votre réponse...">{{ $message->reponse_admin }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Envoyer la réponse</button>
      </form>
    </div>
  </div>

  <!-- Info client -->
  <div class="card" style="align-self:start;">
    <div class="card-header"><div class="card-title"><i class="bi bi-person-fill" style="color:var(--accent)"></i> Client</div></div>
    <div style="display:flex;flex-direction:column;gap:10px; font-size:0.85rem;">
      <div>
        <div class="detail-label">Nom</div>
        <div class="detail-value">{{ $message->client->nom ?? '—' }} {{ $message->client->prenom ?? '' }}</div>
      </div>
      <div>
        <div class="detail-label">Email</div>
        <div class="detail-value">{{ $message->client->email ?? '—' }}</div>
      </div>
      <div>
        <div class="detail-label">Téléphone</div>
        <div class="detail-value">{{ $message->client->telephone ?? '—' }}</div>
      </div>
    </div>
    @if($message->client)
    <div style="margin-top:14px;">
      <a href="{{ route('admin.clients.show',$message->client->id) }}" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;">
        <i class="bi bi-person-lines-fill"></i> Fiche client
      </a>
    </div>
    @endif
  </div>
</div>
@endsection
