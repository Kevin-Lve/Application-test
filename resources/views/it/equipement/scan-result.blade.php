@extends('layouts.app')

@section('title', 'Résultats du scan')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Résultats pour "{{ $code }}"
                </h1>
                <span class="fs-6 text-muted">Sélectionnez la fiche à ouvrir ou ajustez le stock consommable.</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('equipement.scan') }}" class="btn btn-light">Nouveau scan</a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-10">
                @if($equipements->isNotEmpty())
                <div class="col-12 col-lg-6">
                    <div class="card card-flush h-100">
                        <div class="card-header">
                            <h2 class="card-title">Équipements</h2>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Identifiant</th>
                                            <th>Emplacement</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($equipements as $equipement)
                                        <tr>
                                            <td>{{ $equipement->hostname ?? '—' }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">SN : {{ $equipement->numero_serie ?? 'n/a' }}</span>
                                                    <span class="text-muted">MAC : {{ $equipement->adresse_mac ?? 'n/a' }}</span>
                                                    <span class="text-muted">IMMO : {{ $equipement->immo ?? 'n/a' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ optional($equipement->emplacement)->nom ?? 'Non défini' }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('equipement.edit.show', $equipement->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($consommables->isNotEmpty())
                <div class="col-12 col-lg-6" data-module="consommable-adjust">
                    <div class="card card-flush h-100">
                        <div class="card-header">
                            <h2 class="card-title">Consommables</h2>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Stock</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($consommables as $consommable)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">{{ $consommable->nom }}</span>
                                                    <span class="text-muted">Réf : {{ $consommable->reference ?? '—' }}</span>
                                                    <span class="text-muted">Code : {{ $consommable->code_barre ?? ($consommable->numero_serie ?? ($consommable->immo ?? '—')) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-primary fs-6">{{ $consommable->quantite_stock }}</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <form method="POST" action="{{ route('consommables.adjust', $consommable) }}" class="me-2">
                                                        @csrf
                                                        <input type="hidden" name="mode" value="decrease">
                                                        <input type="hidden" name="amount" value="1">
                                                        <button type="submit" class="btn btn-light-danger btn-sm">-1</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('consommables.adjust', $consommable) }}">
                                                        @csrf
                                                        <input type="hidden" name="mode" value="increase">
                                                        <input type="hidden" name="amount" value="1">
                                                        <button type="submit" class="btn btn-light-success btn-sm">+1</button>
                                                    </form>
                                                    <a href="{{ route('consommables.edit', $consommable) }}" class="btn btn-sm btn-primary">Modifier</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
