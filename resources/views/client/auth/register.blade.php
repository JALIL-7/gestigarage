@extends('layouts.client')
@section('title', 'Créer un compte')

@section('content')
<div style="min-height: calc(100vh - 64px); display:flex; align-items:center; justify-content:center; padding: 40px 16px;">
  <div style="width:100%; max-width:460px;">

    <div style="text-align:center; margin-bottom:32px;">
      <div style="width:54px;height:54px;background:linear-gradient(135deg,var(--accent),#ea580c);border-radius:13px;display:inline-flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px;"><i class="bi bi-wrench-adjustable-circle-fill" style="color:white;"></i></div>
      <h1 style="font-size:1.5rem;font-weight:800;">Créer un compte</h1>
      <p style="color:var(--text-muted); font-size:0.85rem; margin-top:6px;">Rejoignez GestiGarage et suivez vos véhicules</p>
    </div>

    <div class="card">
      @if($errors->any())
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i>
          <ul style="margin:0; padding-left:14px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      <form action="{{ route('client.register.post') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
          <div class="form-group">
            <label class="form-label">Nom *</label>
            <input name="nom" class="form-control" value="{{ old('nom') }}" required placeholder="Dupont">
          </div>
          <div class="form-group">
            <label class="form-label">Prénom</label>
            <input name="prenom" class="form-control" value="{{ old('prenom') }}" placeholder="Jean">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="jean@email.com">
        </div>
        <div class="form-group">
          <label class="form-label">Téléphone</label>
          <input name="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="+237 6XX XXX XXX">
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
          <div class="form-group">
            <label class="form-label">Mot de passe *</label>
            <input type="password" name="password" class="form-control" required placeholder="Min. 6 caractères">
          </div>
          <div class="form-group">
            <label class="form-label">Confirmation *</label>
            <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••">
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center; padding:12px;">
          <i class="bi bi-person-plus-fill"></i> Créer mon compte
        </button>
      </form>

      <div style="text-align:center; margin-top:20px; font-size:0.85rem; color:var(--text-muted);">
        Déjà inscrit ?
        <a href="{{ route('client.login') }}" style="color:var(--accent); font-weight:600; text-decoration:none;"> Se connecter</a>
      </div>
    </div>
  </div>
</div>
@endsection
