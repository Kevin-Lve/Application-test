@extends('layouts.app') 

@section('title')
Liste des Utilisateur
@stop

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Liste des Equipements
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card card-flush">
            <div class="card-header mt-6">
    <div class="card-title">
        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('equipement.show.index') }}" class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}" 
                class="form-control form-control-solid w-250px ps-13" 
                placeholder="Rechercher un équipement" />
            <button type="submit" class="btn btn-primary ms-3">Rechercher</button>
        </form>
    </div>
    <div class="card-toolbar">
        <a href="{{ route('equipement.create.show') }}">
            <button type="button" class="btn btn-light-primary">
                <i class="ki-duotone ki-plus-square fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                Ajouter un Equipement
            </button>
        </a>
    </div>
</div>


                <div class="card-body pt-0">
                    <div id="kt_permissions_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                        <div id="" class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0 dataTable" id="kt_permissions_table" style="width: 100%;">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0" role="row">
                                        <th class="min-w-125px">Nom</th>
                                        <th class="min-w-125px">Sous-Categorie</th>
                                        <th class="min-w-125px">Emplacement</th>
                                        <th class="min-w-125px">SN</th>
                                        <th class="min-w-125px">IP</th>
                                        <th class="min-w-125px">MAC</th>
                                        <th class="min-w-125px">Statut</th>
                                        <th class="min-w-125px">Prix</th>
                                        <th class="min-w-125px">Crée le</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach($equipements as $equipement)
                                    <tr>
                                        <td>{{ $equipement->hostname }}</td>
                                        <td>{{ $equipement->sous_categorie->nom }}</td>
                                        <td>{{ $equipement->emplacement->nom  }}</td>
                                        <td>{{ $equipement->numero_serie }}</td>
                                        <td>{{ $equipement->adresse_ip }}</td>
                                        <td>{{ $equipement->adresse_mac }}</td>
                                        <td>{{ $equipement->statut }}</td>
                                        <td>{{ $equipement->prix }}</td>
                                        <td>
                                            @if($equipement->created_at) 
                                                {{ $equipement->created_at->format('d/m/Y H:i') }} 
                                            @else 
                                                - 
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('it.equipement.show', ['id' => $equipement->id]) }}">
                                                <button class="btn btn-icon btn-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('equipement.supprimer', ['id' => $equipement->id]) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet équipement ?')">
                                                <button class="btn btn-icon btn-light-danger w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                                    <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                </button>
                                            </a>
                                           
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="" class="row">
                            {!! $equipements->links('vendor.pagination.kevinPagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
