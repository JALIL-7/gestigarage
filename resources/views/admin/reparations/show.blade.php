@extends('layouts.admin')
@section('title', 'Réparation #'.$reparation->id)
@section('page-title', 'Réparations')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Réparation #{{ $reparation->id }}</div>
    <div class="breadcrumb">
      <a href="{{ route('admin.vehicules.show',$reparation->vehicule->id) }}">{{ $reparation->vehicule->immatriculation }}</a>
      <span>/</span> Réparation
    </div>
  </div>
  <div style="display:flex;gap:8px;">
    <a href="{{ route('admin.vehicules.show',$reparation->vehicule->id) }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
    @if(!$reparation->facture)
      <a href="{{ route('admin.factures.create',$reparation->id) }}" class="btn btn-primary"><i class="bi bi-receipt"></i> Générer facture</a>
    @endif
  </div>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px;">
  <!-- Détails -->
  <div>
    <div class="card" style="margin-bottom:16px;">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-tools" style="color:var(--accent)"></i> Détails</div>
        @if($reparation->statut === 'terminee')
          <span class="badge badge-success"><i class="bi bi-check-circle"></i> Terminée</span>
        @elseif($reparation->statut === 'en cours')
          <span class="badge badge-info"><i class="bi bi-arrow-repeat"></i> En cours</span>
        @elseif($reparation->statut === 'annulee')
          <span class="badge badge-danger"><i class="bi bi-x-circle"></i> Annulée</span>
        @else
          <span class="badge badge-warning"><i class="bi bi-clock"></i> En attente</span>
        @endif
      </div>
      <div class="detail-grid">
        <div class="detail-item">
          <div class="detail-label">Véhicule</div>
          <div class="detail-value">
            <a href="{{ route('admin.vehicules.show',$reparation->vehicule->id) }}" style="color:var(--accent);text-decoration:none;">
              {{ $reparation->vehicule->immatriculation }}
            </a>
            — {{ $reparation->vehicule->marque }} {{ $reparation->vehicule->modele }}
          </div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Client</div>
          <div class="detail-value">
            <a href="{{ route('admin.clients.show',$reparation->vehicule->client->id) }}" style="color:var(--text-primary);text-decoration:none;">
              {{ $reparation->vehicule->client->nom ?? '—' }}
            </a>
          </div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Date début</div>
          <div class="detail-value">{{ $reparation->date_debut ? \Carbon\Carbon::parse($reparation->date_debut)->format('d/m/Y') : '—' }}</div>
        </div>
        <div class="detail-item">
          <div class="detail-label">Date fin</div>
          <div class="detail-value">{{ $reparation->date_fin ? \Carbon\Carbon::parse($reparation->date_fin)->format('d/m/Y') : '—' }}</div>
        </div>
      </div>
      <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border);">
        <div class="detail-label">Description de la panne</div>
        <p style="margin-top:6px; color:var(--text-primary); line-height:1.6;">{{ $reparation->description_panne }}</p>
      </div>
      @if($reparation->remarque)
      <div style="margin-top:12px;">
        <div class="detail-label">Remarques</div>
        <p style="margin-top:6px; color:var(--text-secondary);">{{ $reparation->remarque }}</p>
      </div>
      @endif
    </div>
  </div>

  <!-- Coûts -->
  <div>
    <div class="card" style="margin-bottom:16px;">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-cash-coin" style="color:var(--accent)"></i> Coûts</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        <div style="display:flex;justify-content:space-between;font-size:0.85rem;">
          <span style="color:var(--text-secondary);">Main-d'œuvre</span>
          <span style="font-weight:600;">{{ number_format($reparation->cout_main_oeuvre,0,',',' ') }} F</span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:0.85rem;">
          <span style="color:var(--text-secondary);">Pièces</span>
          <span style="font-weight:600;">{{ number_format($reparation->cout_pieces,0,',',' ') }} F</span>
        </div>
        <div style="height:1px;background:var(--border);"></div>
        <div style="display:flex;justify-content:space-between;">
          <span style="font-weight:700;">Total</span>
          <span style="font-weight:800;font-size:1.1rem;color:var(--accent);">
            {{ number_format($reparation->cout_main_oeuvre + $reparation->cout_pieces,0,',',' ') }} F
          </span>
        </div>
      </div>
    </div>

    @if($reparation->facture)
    <div class="card">
      <div class="card-header"><div class="card-title"><i class="bi bi-receipt" style="color:var(--success)"></i> Facture</div></div>
      <div style="font-size:0.85rem;">
        <div style="font-weight:700; font-size:1rem; margin-bottom:8px;">N° {{ $reparation->facture->numero }}</div>
        <div style="color:var(--text-secondary); margin-bottom:8px;">{{ $reparation->facture->date_facture }}</div>
        <span class="badge {{ $reparation->facture->statut === 'payee' ? 'badge-success' : 'badge-danger' }}">
          {{ $reparation->facture->statut === 'payee' ? 'Payée' : 'Impayée' }}
        </span>
      </div>
      <div style="margin-top:12px;display:flex;gap:8px;">
        <a href="{{ route('admin.factures.show',$reparation->facture->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-eye"></i> Voir</a>
        <a href="{{ route('admin.factures.pdf',$reparation->facture->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> PDF</a>
      </div>
    </div>
    @endif

    <div class="card" style="margin-top:16px;">
      <div class="card-header">
        <div class="card-title"><i class="bi bi-pencil-square" style="color:var(--accent)"></i> Modifier la réparation</div>
      </div>
      <form action="{{ route('admin.reparations.update', $reparation->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
          <label class="form-label">Statut</label>
          <select name="statut" class="form-control">
            <option value="en attente" {{ old('statut', $reparation->statut) == 'en attente' ? 'selected' : '' }}>En attente</option>
            <option value="en cours" {{ old('statut', $reparation->statut) == 'en cours' ? 'selected' : '' }}>En cours</option>
            <option value="terminee" {{ old('statut', $reparation->statut) == 'terminee' ? 'selected' : '' }}>Terminée</option>
            <option value="annulee" {{ old('statut', $reparation->statut) == 'annulee' ? 'selected' : '' }}>Annulée</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Description panne</label>
          <textarea name="description_panne" class="form-control" rows="2" required>{{ old('description_panne', $reparation->description_panne) }}</textarea>
        </div>

        <div class="form-group">
          <label class="form-label">Coût Main d'œuvre (F)</label>
          <input type="number" step="0.01" name="cout_main_oeuvre" class="form-control" value="{{ old('cout_main_oeuvre', $reparation->cout_main_oeuvre) }}">
        </div>

        <div class="form-group">
          <label class="form-label">Coût Pièces (F)</label>
          <input type="number" step="0.01" name="cout_pieces" class="form-control" value="{{ old('cout_pieces', $reparation->cout_pieces) }}">
        </div>

        <div class="form-group">
          <label class="form-label">Date fin</label>
          <input type="date" name="date_fin" class="form-control" value="{{ old('date_fin', $reparation->date_fin) }}">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
          <i class="bi bi-save"></i> Enregistrer
        </button>
      </form>
    </div>
  </div>
</div>
@endsection