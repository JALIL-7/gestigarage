@extends('layouts.admin')
@section('title', 'Nouvelle réparation')
@section('page-title', 'Réparations')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Nouvelle réparation</div>
    <div class="breadcrumb">
      <a href="{{ route('admin.vehicules.show',$vehicule->id) }}">{{ $vehicule->immatriculation }}</a> <span>/</span> Ajouter réparation
    </div>
  </div>
  <a href="{{ route('admin.vehicules.show',$vehicule->id) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card" style="max-width:620px;">
  <div style="padding:12px 16px; background:var(--accent-soft); border-radius:8px; margin-bottom:20px; font-size:0.85rem;">
    <i class="bi bi-car-front-fill" style="color:var(--accent)"></i>
    Véhicule : <strong>{{ $vehicule->immatriculation }}</strong> — {{ $vehicule->marque }} {{ $vehicule->modele }}
    | Propriétaire : <strong>{{ $vehicule->client->nom ?? '' }}</strong>
  </div>

  @if($errors->any())
    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i>
      <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.reparations.store') }}" method="POST">
    @csrf
    <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">
    <div class="form-group">
      <label class="form-label">Description de la panne *</label>
      <textarea name="description_panne" class="form-control" required rows="3" placeholder="Décrivez la panne...">{{ old('description_panne') }}</textarea>
    </div>
    <div class="form-group">
      <label class="form-label">Remarques</label>
      <textarea name="remarque" class="form-control" rows="2" placeholder="Notes internes...">{{ old('remarque') }}</textarea>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Coût main-d'œuvre (F)</label>
        <input name="cout_main_oeuvre" type="number" step="0.01" class="form-control" value="{{ old('cout_main_oeuvre',0) }}">
      </div>
      <div class="form-group">
        <label class="form-label">Coût pièces (F)</label>
        <input name="cout_pieces" type="number" step="0.01" class="form-control" value="{{ old('cout_pieces',0) }}">
      </div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="form-group">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-control" readonly>
          <option value="en attente" selected>En attente</option>
        </select>
        <small style="color:var(--text-muted);font-size:0.7rem;margin-top:4px;display:block;">Se définit sur "en attente" à la création.</small>
      </div>
      <div class="form-group">
        <label class="form-label">Date début</label>
        <input type="date" name="date_debut" class="form-control" value="{{ old('date_debut', now()->toDateString()) }}">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Date fin estimée</label>
      <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}">
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-tools"></i> Créer la réparation</button>
  </form>
</div>
@endsection