<div class="row g-5">
    <div class="col-md-6">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" value="{{ old('nom', $consommable->nom ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Référence</label>
        <input type="text" name="reference" value="{{ old('reference', $consommable->reference ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Code barre</label>
        <input type="text" name="code_barre" value="{{ old('code_barre', $consommable->code_barre ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">N° série</label>
        <input type="text" name="numero_serie" value="{{ old('numero_serie', $consommable->numero_serie ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">N° IMMO</label>
        <input type="text" name="immo" value="{{ old('immo', $consommable->immo ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Adresse MAC</label>
        <input type="text" name="adresse_mac" value="{{ old('adresse_mac', $consommable->adresse_mac ?? '') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Stock actuel *</label>
        <input type="number" min="0" name="quantite_stock" value="{{ old('quantite_stock', $consommable->quantite_stock ?? 0) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Seuil minimal</label>
        <input type="number" min="0" name="quantite_minimale" value="{{ old('quantite_minimale', $consommable->quantite_minimale ?? 0) }}" class="form-control">
    </div>
</div>
