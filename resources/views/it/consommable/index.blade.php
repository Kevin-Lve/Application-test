@extends('layouts.app')

@section('title', 'Consommables IT')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Consommables
                </h1>
                <span class="fs-6 text-muted">Suivi des stocks pour les câbles, adaptateurs et petits équipements.</span>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('consommables.create') }}" class="btn btn-primary">Ajouter un consommable</a>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card card-flush">
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Référence</th>
                                    <th>Stock</th>
                                    <th>Seuil mini</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($consommables as $consommable)
                                    <tr>
                                        <td>{{ $consommable->nom }}</td>
                                        <td>{{ $consommable->reference ?? '—' }}</td>
                                        <td>
                                            <span class="badge {{ $consommable->quantite_stock <= $consommable->quantite_minimale ? 'badge-light-danger' : 'badge-light-success' }} fs-6">
                                                {{ $consommable->quantite_stock }}
                                            </span>
                                        </td>
                                        <td>{{ $consommable->quantite_minimale }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('consommables.edit', $consommable) }}" class="btn btn-sm btn-primary">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-10">Aucun consommable enregistré pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        {{ $consommables->links('vendor.pagination.kevinPagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
