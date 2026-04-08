@extends('layouts.admin')
@section('title', 'Ajouter véhicule')
@section('page-title', 'Véhicules')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Ajouter un véhicule</div>
    <div class="breadcrumb">
      <a href="{{ route('admin.clients.show',$client->id) }}">{{ $client->nom }}</a> <span>/</span> Nouveau véhicule
    </div>
  </div>
  <a href="{{ route('admin.clients.show',$client->id) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card" style="max-width:540px;">
  <div style="padding:12px 16px; background:var(--accent-soft); border-radius:8px; margin-bottom:20px; font-size:0.85rem;">
    <i class="bi bi-person-fill" style="color:var(--accent)"></i>
    Véhicule pour : <strong>{{ $client->nom }} {{ $client->prenom ?? '' }}</strong>
  </div>

  @if($errors->any())
    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i>
      <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.vehicules.store') }}" method="POST">
    @csrf
    <input type="hidden" name="client_id" value="{{ $client->id }}">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Marque *</label>
        <input name="marque" class="form-control" value="{{ old('marque') }}" required placeholder="Toyota">
      </div>
      <div class="form-group">
        <label class="form-label">Modèle *</label>
        <input name="modele" class="form-control" value="{{ old('modele') }}" required placeholder="Corolla">
      </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Année</label>
        <input name="annee" class="form-control" value="{{ old('annee') }}" placeholder="2020">
      </div>
      <div class="form-group">
        <label class="form-label">Immatriculation *</label>
        <input name="immatriculation" class="form-control" value="{{ old('immatriculation') }}" required placeholder="LT-1234-YA" style="text-transform:uppercase;">
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-car-front-fill"></i> Enregistrer</button>
  </form>
</div>
@endsection