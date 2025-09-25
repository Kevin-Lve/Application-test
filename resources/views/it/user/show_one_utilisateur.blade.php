@extends('layouts.app')

@section('title')
Détails de l’utilisateur
@stop

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    {{-- Toolbar --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 my-0">
                     {{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}
                </h1>
                @if(!empty($user->email))
                    <span class="text-muted fs-7">Email : {{ $user->email }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- Fiche utilisateur --}}
            <div class="card card-flush mb-10">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="fw-bold">Fiche utilisateur</h2>
                    </div>
                </div>
                <div class="card-body py-5">
                    <div class="row g-5">
                        <div class="col-md-4">
                            <div class="fw-semibold text-gray-600">
                                <div class="mb-2"><span class="fw-bold text-gray-800">Nom :</span> {{ $user->nom ?? '-' }}</div>
                                <div class="mb-2"><span class="fw-bold text-gray-800">Prénom :</span> {{ $user->prenom ?? '-' }}</div>
                                <div class="mb-2"><span class="fw-bold text-gray-800">Email :</span> {{ $user->email ?? '-' }}</div>
                                <div class="mb-2"><span class="fw-bold text-gray-800">Rôle :</span> {{ optional($user->role)->nom ?? '-' }}</div>
                                <div class="mb-2"><span class="fw-bold text-gray-800">Service :</span> {{ optional($user->service)->nom ?? '-' }}</div>
                                <div class="mb-2"><span class="fw-bold text-gray-800">Créé le :</span> {{ optional($user->created_at)->format('d/m/Y') ?? '-' }}</div>
                            </div>
                        </div>

                        {{-- KPIs (pédago) --}}
                        <div class="col-md-8">
                            <div class="row g-5">
                                <div class="col-md-4">
                                    <div class="card bg-light-primary p-5 h-100">
                                        <div class="fs-7 text-muted">Nb équipements</div>
                                        <div class="fs-2 fw-bold">{{ $nb_equipements }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light-success p-5 h-100">
                                        <div class="fs-7 text-muted">Valeur totale</div>
                                        <div class="fs-2 fw-bold">
                                            @php $val = $valeur_totale ?? 0; @endphp
                                            {{ number_format($val, 2, ',', ' ') }} €
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light-warning p-5 h-100">
                                        <div class="fs-7 text-muted">Dernier attribué</div>
                                        <div class="fs-6 fw-bold">{{ optional($dernier_attribue)->format('d/m/Y H:i') ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- /KPIs --}}
                    </div>
                </div>
            </div>

            {{-- Tableau équipements attribués (même look que it/equipement/index) --}}
            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title"><h2 class="fw-bold">Équipements attribués</h2></div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0 dataTable" style="width:100%;">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nom</th>
                                    <th class="min-w-125px">Sous-Categorie</th>
                                    <th class="min-w-125px">Emplacement</th>
                                    <th class="min-w-125px">SN</th>
                                    <th class="min-w-125px">IP</th>
                                    <th class="min-w-125px">MAC</th>
                                    <th class="min-w-125px">Statut</th>
                                    <th class="min-w-125px">Prix</th>
                                    <th class="min-w-125px">Créé le</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @forelse($equipements as $equipement)
                                    <tr>
                                        <td>{{ $equipement->hostname }}</td>
                                        <td>{{ optional($equipement->sous_categorie)->nom ?? '-' }}</td>
                                        <td>{{ optional($equipement->emplacement)->nom ?? '-' }}</td>
                                        <td>{{ $equipement->numero_serie ?? '-' }}</td>
                                        <td>{{ $equipement->adresse_ip ?? '-' }}</td>
                                        <td>{{ $equipement->adresse_mac ?? '-' }}</td>
                                        <td>{{ $equipement->statut ?? '-' }}</td>
                                        <td>
                                            @if(!is_null($equipement->prix))
                                                {{ number_format($equipement->prix, 2, ',', ' ') }} €
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ optional($equipement->created_at)->format('d/m/Y') ?? '-' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('it.equipement.show', ['id' => $equipement->id]) }}" class="btn btn-sm btn-light">
                                                Voir
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-10">Aucun équipement attribué.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination compacte + x–y / total --}}
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <div class="text-sm text-muted">
                            @if($equipements->total() > 0)
                                {{ $equipements->firstItem() }}–{{ $equipements->lastItem() }} / {{ $equipements->total() }}
                            @else
                                0 / 0
                            @endif
                        </div>
                        <div>
                            {!! $equipements->links('vendor.pagination.kevinPagination') !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@stop
