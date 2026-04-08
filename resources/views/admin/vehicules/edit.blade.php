@extends('layouts.admin')
@section('title', 'Modifier véhicule')
@section('page-title', 'Véhicules')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Modifier le véhicule</div>
    <div class="breadcrumb">
      <a href="{{ route('admin.vehicules.index') }}">Véhicules</a> <span>/</span>
      <a href="{{ route('admin.vehicules.show',$vehicule->id) }}">{{ $vehicule->immatriculation }}</a> <span>/</span> Modifier
    </div>
  </div>
  <a href="{{ route('admin.vehicules.show',$vehicule->id) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card" style="max-width:540px;">
  @if($errors->any())
    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i>
      <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.vehicules.update',$vehicule->id) }}" method="POST">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Marque *</label>
        <input name="marque" class="form-control" value="{{ old('marque',$vehicule->marque) }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Modèle *</label>
        <input name="modele" class="form-control" value="{{ old('modele',$vehicule->modele) }}" required>
      </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Année</label>
        <input name="annee" class="form-control" value="{{ old('annee',$vehicule->annee) }}" placeholder="ex: 2018">
      </div>
      <div class="form-group">
        <label class="form-label">Immatriculation *</label>
        <input name="immatriculation" class="form-control" value="{{ old('immatriculation',$vehicule->immatriculation) }}" required style="text-transform:uppercase;">
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Mettre à jour</button>
  </form>
</div>
@endsection