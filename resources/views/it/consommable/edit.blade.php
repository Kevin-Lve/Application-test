@extends('layouts.app')

@section('title', 'Modifier un consommable')

@section('content')
<div class="d-flex flex-column flex-column-fluid" data-module="consommable-adjust">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ $consommable->nom }}
                </h1>
                <span class="fs-6 text-muted">Stock actuel : {{ $consommable->quantite_stock }} pièce(s).</span>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('consommables.index') }}" class="btn btn-light">Retour liste</a>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card card-flush mb-10">
                <div class="card-body py-10">
                    <form method="POST" action="{{ route('consommables.update', $consommable) }}">
                        @csrf
                        @method('PUT')
                        @include('it.consommable._form')
                        <div class="mt-10 d-flex gap-3">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-flush">
                <div class="card-header">
                    <h2 class="card-title">Ajustements rapides</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('consommables.adjust', $consommable) }}" class="d-flex flex-wrap gap-3 align-items-center">
                        @csrf
                        <div class="input-group w-auto">
                            <select name="mode" class="form-select">
                                <option value="increase">Ajouter</option>
                                <option value="decrease">Retirer</option>
                            </select>
                            <input type="number" min="1" name="amount" value="1" class="form-control w-100px">
                        </div>
                        <button type="submit" class="btn btn-primary">Appliquer</button>
                        <span class="text-muted">Kevin: je force un passage par ce mini-formulaire pour garder un audit mental de chaque mouvement de stock.</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
