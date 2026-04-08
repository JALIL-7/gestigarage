@extends('layouts.client')
@section('title', 'Connexion')

@section('content')
<div style="min-height: calc(100vh - 64px); display:flex; align-items:center; justify-content:center; padding: 40px 16px;">
  <div style="width:100%; max-width:420px;">

    <!-- Logo -->
    <div style="text-align:center; margin-bottom:32px;">
      <div style="width:54px;height:54px;background:linear-gradient(135deg,var(--accent),#ea580c);border-radius:13px;display:inline-flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px;"><i class="bi bi-wrench-adjustable-circle-fill" style="color:white;"></i></div>
      <h1 style="font-size:1.5rem;font-weight:800;">Connexion</h1>
      <p style="color:var(--text-muted); font-size:0.85rem; margin-top:6px;">Accédez à votre espace client GestiGarage</p>
    </div>

    <div class="card">
      @if($errors->any())
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i>
          {{ $errors->first() }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
      @endif

      <form action="{{ route('client.login.post') }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Adresse email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="votre@email.com">
        </div>
        <div class="form-group">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" required placeholder="••••••••">
        </div>
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
          <label style="display:flex;align-items:center;gap:8px;font-size:0.83rem;cursor:pointer;color:var(--text-muted);">
            <input type="checkbox" name="remember" style="accent-color:var(--accent)"> Se souvenir de moi
          </label>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center; padding:12px;">
          <i class="bi bi-box-arrow-in-right"></i> Se connecter
        </button>
      </form>

      <div style="text-align:center; margin-top:20px; font-size:0.85rem; color:var(--text-muted);">
        Pas encore de compte ?
        <a href="{{ route('client.register') }}" style="color:var(--accent); font-weight:600; text-decoration:none;"> Créer un compte</a>
      </div>
    </div>
  </div>
</div>
@endsection
