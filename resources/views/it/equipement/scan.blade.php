@extends('layouts.app')

@section('title', 'Scan inventaire')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Scan rapide inventaire
                </h1>
                <span class="fs-6 text-muted">Présentez le code-barres ou saisissez l'identifiant pour retrouver l'équipement en moins de 3 clics.</span>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card card-flush">
                <div class="card-body py-10">
                    <form method="POST" action="{{ route('equipement.scan.search') }}" id="scan-form" class="d-flex flex-column gap-5" data-module="scan-input">
                        @csrf
                        <div class="d-flex flex-column gap-2">
                            <label for="code" class="form-label fs-5">Code scanné ou saisi</label>
                            <input type="text" name="code" id="code" class="form-control form-control-lg" placeholder="Scannez un code barre, MAC, n° série, IMMO..." autocomplete="off" autofocus required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-lg">Lancer la recherche</button>
                        </div>
                        <p class="text-muted m-0">Astuce : la scannette USB se comporte comme un clavier, on reste donc focus dans le champ pour enchaîner les scans.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
