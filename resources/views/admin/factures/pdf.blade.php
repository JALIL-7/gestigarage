// ...existing code...
<!doctype html>
<html><head><meta charset="utf-8"><title>Facture {{ $facture->numero }}</title>
<style>
body{font-family: DejaVu Sans, sans-serif; font-size:12px}
.header{text-align:center;margin-bottom:20px}
.table{width:100%;border-collapse:collapse}
.table th,.table td{border:1px solid #ccc;padding:8px}
.footer{margin-top:30px;text-align:right}
.signature{margin-top:40px}
</style>
</head>
<body>
  <div class="header">
    <h2>Garage - Facture</h2>
    <div>Facture : {{ $facture->numero }} — Date : {{ $facture->date_facture }}</div>
  </div>

  <div>
    <strong>Client :</strong><br>
    {{ $facture->reparation->vehicule->client->nom }} {{ $facture->reparation->vehicule->client->prenom ?? '' }}<br>
    {{ $facture->reparation->vehicule->client->telephone ?? '' }}<br>
    {{ $facture->reparation->vehicule->client->email ?? '' }}
  </div>

  <div style="margin-top:10px">
    <strong>Véhicule :</strong><br>
    {{ $facture->reparation->vehicule->marque }} {{ $facture->reparation->vehicule->modele }} — {{ $facture->reparation->vehicule->immatriculation }}
  </div>

  <h4>Détails réparation</h4>
  <div>{{ $facture->reparation->description_panne }}</div>

  <table class="table" style="margin-top:10px">
    <thead><tr><th>Prestation</th><th>Montant</th></tr></thead>
    <tbody>
      <tr><td>Main-œuvre</td><td>{{ number_format($facture->reparation->cout_main_oeuvre,2,',',' ') }} €</td></tr>
      <tr><td>Pièces</td><td>{{ number_format($facture->reparation->cout_pieces,2,',',' ') }} €</td></tr>
      <tr><th>Total</th><th>{{ number_format($facture->montant_total,2,',',' ') }} €</th></tr>
    </tbody>
  </table>

  <div class="footer">
    <div class="signature">Signature garage: ________________________</div>
  </div>
</body>
</html>