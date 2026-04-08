@extends('layouts.admin')
@section('title', 'Créer facture')
@section('page-title', 'Factures')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Créer une facture</div>
    <div class="breadcrumb">
      <a href="{{ route('admin.reparations.show',$reparation->id) }}">Réparation #{{ $reparation->id }}</a> <span>/</span> Facture
    </div>
  </div>
  <a href="{{ route('admin.reparations.show',$reparation->id) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="card" style="max-width:500px;">
  <div style="padding:12px 16px; background:var(--accent-soft); border-radius:8px; margin-bottom:20px; font-size:0.85rem; line-height:1.8">
    <div><i class="bi bi-car-front-fill" style="color:var(--accent)"></i> <strong>{{ $reparation->vehicule->immatriculation }}</strong> — {{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}</div>
    <div><i class="bi bi-person-fill" style="color:var(--accent)"></i> {{ $reparation->vehicule->client->nom ?? '' }} {{ $reparation->vehicule->client->prenom ?? '' }}</div>
    <div><i class="bi bi-tools" style="color:var(--accent)"></i> {{ Str::limit($reparation->description_panne,60) }}</div>
    <div style="font-weight:700; margin-top:4px;">Total : {{ number_format($reparation->cout_main_oeuvre + $reparation->cout_pieces, 0, ',', ' ') }} F</div>
  </div>

  <form action="{{ route('admin.factures.store') }}" method="POST">
    @csrf
    <input type="hidden" name="reparation_id" value="{{ $reparation->id }}">
    <div class="form-group">
      <label class="form-label">Date de la facture</label>
      <input type="date" name="date_facture" class="form-control" value="{{ old('date_facture', now()->toDateString()) }}">
    </div>
    <button type="submit" class="btn btn-primary"><i class="bi bi-receipt"></i> Générer la facture</button>
  </form>
</div>
@endsection