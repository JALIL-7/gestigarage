@extends('layouts.admin')
@section('title', 'Nouveau client')
@section('page-title', 'Clients')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Nouveau client</div>
    <div class="breadcrumb"><a href="{{ route('admin.clients.index') }}">Clients</a> <span>/</span> Ajouter</div>
  </div>
  <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card" style="max-width:620px;">
  @if($errors->any())
    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i>
      <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.clients.store') }}" method="POST">
    @csrf
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label class="form-label">Nom *</label>
        <input name="nom" class="form-control" value="{{ old('nom') }}" required placeholder="Dupont">
      </div>
      <div class="form-group">
        <label class="form-label">Prénom</label>
        <input name="prenom" class="form-control" value="{{ old('prenom') }}" placeholder="Jean">
      </div>
    </div>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label class="form-label">Téléphone</label>
        <input name="telephone" class="form-control" value="{{ old('telephone') }}" placeholder="+237 6XX XXX XXX">
      </div>
      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="jean@email.com">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Adresse</label>
      <input name="adresse" class="form-control" value="{{ old('adresse') }}" placeholder="Rue, Ville">
    </div>
    <div class="form-group">
      <label class="form-label">Mot de passe (portail client)</label>
      <input type="password" name="password" class="form-control" placeholder="Laisser vide pour désactiver l'accès">
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Enregistrer</button>
  </form>
</div>
@endsection