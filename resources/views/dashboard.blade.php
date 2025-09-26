@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="d-flex flex-column flex-column-fluid" data-module="charts" data-chart-config='@json($chartData)'>
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Vue d'ensemble de l'inventaire
                </h1>
                <span class="fs-6 text-muted">Analyse instantanée du parc, des attributions et des dernières actions.</span>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-6 mb-8">
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <span class="fs-6 text-muted">Équipements suivis</span>
                            <div class="d-flex align-items-baseline mt-3">
                                <span class="fs-2hx fw-bold text-gray-900">{{ $kpis['totalEquipements'] }}</span>
                            </div>
                            <p class="text-muted mt-3 mb-0">Nombre total d'objets inventoriés.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <span class="fs-6 text-muted">Attribués aux utilisateurs</span>
                            <div class="d-flex align-items-baseline mt-3">
                                <span class="fs-2hx fw-bold text-gray-900">{{ $kpis['attribuesUtilisateurs'] }}</span>
                            </div>
                            <p class="text-muted mt-3 mb-0">Postes affectés directement à une personne.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <span class="fs-6 text-muted">Attribués aux services</span>
                            <div class="d-flex align-items-baseline mt-3">
                                <span class="fs-2hx fw-bold text-gray-900">{{ $kpis['attribuesServices'] }}</span>
                            </div>
                            <p class="text-muted mt-3 mb-0">Matériel suivi par une équipe.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <span class="fs-6 text-muted">En stock</span>
                            <div class="d-flex align-items-baseline mt-3">
                                <span class="fs-2hx fw-bold text-gray-900">{{ $kpis['enStock'] }}</span>
                            </div>
                            <p class="text-muted mt-3 mb-0">Unités disponibles pour les futures attributions.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-6">
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm mb-6">
                        <div class="card-header border-0 pb-0">
                            <h2 class="card-title">Évolution mensuelle</h2>
                        </div>
                        <div class="card-body">
                            <canvas data-chart="monthly" height="180"></canvas>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-header border-0 pb-0">
                            <h2 class="card-title">Top sous-catégories</h2>
                        </div>
                        <div class="card-body">
                            <canvas data-chart="category" height="180"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card border-0 shadow-sm mb-6">
                        <div class="card-header border-0 pb-0">
                            <h2 class="card-title">Répartition par statut</h2>
                        </div>
                        <div class="card-body">
                            <canvas data-chart="status" height="220"></canvas>
                            <ul class="list-unstyled mt-5 mb-0">
                                @foreach ($statusBreakdown as $row)
                                    <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-dashed">
                                        <span class="fw-semibold text-gray-700">{{ $row->action->nom ?? 'Non défini' }}</span>
                                        <span class="text-muted">{{ $row->total }} équipements</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-header border-0 pb-0">
                            <h2 class="card-title">Dernières actions</h2>
                        </div>
                        <div class="card-body">
                            <ul class="timeline">
                                @forelse ($recentLogs as $log)
                                    <li class="timeline-item mb-4">
                                        <span class="timeline-badge bg-primary"></span>
                                        <div class="timeline-content ps-3">
                                            <span class="fw-semibold text-gray-900">{{ optional($log->equipement)->hostname ?? optional($log->equipement)->numero_serie ?? 'Équipement' }}</span>
                                            <div class="text-muted small">{{ optional($log->created_at)->format('d/m/Y H:i') ?? 'Date inconnue' }}</div>
                                            <div class="text-gray-600 small mt-1">{{ $log->description ?? 'Mise à jour' }}</div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted">Aucune activité récente.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
