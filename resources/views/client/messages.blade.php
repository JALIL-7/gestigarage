@extends('layouts.client')
@section('title', 'Mes messages')

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
        <div class="page-title">Messages</div>
        <div class="page-subtitle">Communiquez directement avec notre équipe</div>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; align-items:start;">

      <!-- Formulaire envoyer message -->
      <div class="card">
        <div class="card-header">
          <div class="card-title"><i class="bi bi-send-fill" style="color:var(--accent)"></i> Envoyer un message</div>
        </div>
        @if($errors->any())
          <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i>
            {{ $errors->first() }}
          </div>
        @endif
        <form action="{{ route('client.messages.send') }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="form-label">Sujet *</label>
            <input name="sujet" class="form-control" required value="{{ old('sujet') }}" placeholder="Objet de votre message...">
          </div>
          <div class="form-group">
            <label class="form-label">Message *</label>
            <textarea name="contenu" class="form-control" required rows="5" placeholder="Décrivez votre demande...">{{ old('contenu') }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
            <i class="bi bi-send-fill"></i> Envoyer
          </button>
        </form>
      </div>

      <!-- Historique des messages -->
      <div>
        <div class="card">
          <div class="card-header">
            <div class="card-title"><i class="bi bi-chat-dots-fill" style="color:var(--accent)"></i> Historique</div>
            <span style="font-size:0.78rem;color:var(--text-muted);">{{ $messages->count() }} message(s)</span>
          </div>
          @if($messages->count())
          <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($messages as $msg)
            <div style="background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:10px;padding:14px;">
              <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <div style="font-weight:600;font-size:0.875rem;">{{ $msg->sujet }}</div>
                @if($msg->statut === 'repondu')
                  <span class="badge badge-success"><i class="bi bi-reply-fill"></i> Répondu</span>
                @elseif($msg->statut === 'lu')
                  <span class="badge badge-muted"><i class="bi bi-envelope-open"></i> Lu</span>
                @else
                  <span class="badge badge-warning"><i class="bi bi-envelope-fill"></i> Envoyé</span>
                @endif
              </div>
              <div style="font-size:0.82rem;color:#64748b;margin-bottom:8px;">{{ Str::limit($msg->contenu, 80) }}</div>
              <div style="font-size:0.75rem;color:#475569;">{{ $msg->created_at->format('d/m/Y H:i') }}</div>

              @if($msg->reponse_admin)
              <div style="margin-top:10px;padding:10px 12px;background:rgba(16,185,129,0.06);border-left:3px solid var(--success);border-radius:0 6px 6px 0;">
                <div style="font-size:0.72rem;color:var(--success);font-weight:700;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">Réponse du garage</div>
                <div style="font-size:0.82rem;color:#94a3b8;line-height:1.5;">{{ $msg->reponse_admin }}</div>
                @if($msg->repondu_le)
                  <div style="font-size:0.72rem;color:#475569;margin-top:4px;">{{ \Carbon\Carbon::parse($msg->repondu_le)->format('d/m/Y H:i') }}</div>
                @endif
              </div>
              @endif
            </div>
            @endforeach
          </div>
          @else
          <div style="text-align:center;padding:30px;color:var(--text-muted);">
            <i class="bi bi-chat" style="font-size:2.5rem;display:block;margin-bottom:10px;"></i>
            Aucun message pour le moment.
          </div>
          @endif
        </div>
      </div>
    </div>
  </main>
</div>
@endsection
