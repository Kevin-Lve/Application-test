@extends('layouts.app')

@section('title')
Afficher Fournisseur
@stop

@section('content')
@php
    // URL du logo via le disque "photo_fournisseur"
    $logoUrl = null;
    if (!empty($fournisseur->image)) {
        try {
            $logoUrl = \Storage::disk('photo_fournisseur')->url($fournisseur->image);
        } catch (\Exception $e) {
            $logoUrl = null;
        }
    }
    $initials = strtoupper(mb_substr($fournisseur->nom ?? 'F', 0, 2));
@endphp

<div class="d-flex flex-column flex-column-fluid">

    {{-- Toolbar --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 my-0">
                    Fournisseur : {{ $fournisseur->nom ?? '-' }}
                </h1>
                @if(!empty($fournisseur->email))
                    <span class="text-muted fs-7">Email : {{ $fournisseur->email }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">

            {{-- Fiche + KPIs --}}
            <div class="card card-flush mb-10">
                <div class="card-header">
                    <div class="card-title"><h2 class="fw-bold">Fiche fournisseur</h2></div>
                    <div class="card-toolbar">
                        <div class="symbol symbol-48px symbol-circle">
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="Logo {{ $fournisseur->nom }}"
                                     style="object-fit:cover; width:48px; height:48px; border-radius:50%;">
                            @else
                                <div class="symbol-label bg-light-primary text-primary fw-bold d-flex align-items-center justify-content-center"
                                     style="width:48px; height:48px; border-radius:50%; font-size:14px;">
                                    {{ $initials }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body py-5">
                    <div class="d-flex align-items-center mb-7">
                        <div class="symbol symbol-80px symbol-circle me-4">
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="Logo {{ $fournisseur->nom }}"
                                     style="object-fit:cover; width:80px; height:80px; border-radius:50%;">
                            @else
                                <div class="symbol-label bg-light-primary text-primary fw-bold d-flex align-items-center justify-content-center"
                                     style="width:80px; height:80px; border-radius:50%; font-size:22px;">
                                    {{ $initials }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="fs-4 fw-bold text-gray-900">{{ $fournisseur->nom ?? '-' }}</div>
                            @if(!empty($fournisseur->email))
                                <div class="text-muted">{{ $fournisseur->email }}</div>
                            @endif
                            @if(!empty($fournisseur->telephone))
                                <div class="text-muted">{{ $fournisseur->telephone }}</div>
                            @endif
                            @if(!empty($fournisseur->adresse))
                                <div class="text-muted">{{ $fournisseur->adresse }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="row g-5">
                        <div class="col-md-3">
                            <div class="card bg-light-primary p-5 h-100">
                                <div class="fs-7 text-muted">Nb équipements</div>
                                <div class="fs-2 fw-bold">{{ $nb_equipements_total }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light-success p-5 h-100">
                                <div class="fs-7 text-muted">Valeur totale</div>
                                <div class="fs-2 fw-bold">
                                    @php $val = $valeur_totale ?? 0; @endphp
                                    {{ number_format($val, 2, ',', ' ') }} €
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light-info p-5 h-100">
                                <div class="fs-7 text-muted">Sous-catégories</div>
                                <div class="fs-2 fw-bold">{{ $nb_sous_categories }}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light-warning p-5 h-100">
                                <div class="fs-7 text-muted">Dernier ajout</div>
                                <div class="fs-6 fw-bold">{{ optional($dernier_attribue)->format('d/m/Y H:i') ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Barre de recherche + perPage --}}
            <div class="card card-flush mb-5">
                <div class="card-body py-5">
                    <form method="GET" action="{{ route('it.fournisseur.show', ['id' => $fournisseur->id]) }}" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" value="{{ $search }}" class="form-control"
                                   placeholder="Rechercher (nom, SN, IP, MAC, statut/action)">
                        </div>
                        <div class="col-md-3">
                            <select name="perPage" class="form-select" onchange="this.form.submit()">
                                @foreach([5,10,15,25,50] as $n)
                                    <option value="{{ $n }}" @selected($perPage==$n)>{{ $n }} par page</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" type="submit">Filtrer</button>
                            <a href="{{ route('it.fournisseur.show', ['id' => $fournisseur->id]) }}" class="btn btn-light">Réinitialiser</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tableau équipements --}}
            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title"><h2 class="fw-bold">Équipements</h2></div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0 dataTable" style="width:100%;">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Nom</th>
                                    <th class="min-w-125px">Sous-Catégorie</th>
                                    <th class="min-w-125px">Emplacement</th>
                                    <th class="min-w-125px">SN</th>
                                    <th class="min-w-125px">IP</th>
                                    <th class="min-w-125px">MAC</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="min-w-125px">Prix</th>
                                    <th class="min-w-125px">Créé le</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @forelse($equipements as $e)
                                    <tr>
                                        <td>{{ $e->hostname }}</td>
                                        <td>{{ optional($e->sous_categorie)->nom ?? '-' }}</td>
                                        <td>{{ optional($e->emplacement)->nom ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $e->numero_serie ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $e->adresse_ip ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $e->adresse_mac ?? '-' }}</td>
                                        <td class="text-nowrap">{{ optional($e->action)->nom ?? '-' }}</td>
                                        <td class="text-end text-nowrap">
                                            @if(!is_null($e->prix))
                                                {{ number_format($e->prix, 2, ',', ' ') }} €
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ optional($e->created_at)->format('d/m/Y') ?? '-' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('it.equipement.show', ['id' => $e->id]) }}" class="btn btn-sm btn-light">Voir</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-10">Aucun équipement trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination + x–y / total --}}
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
