@extends('layouts.app') 

@section('title')
Liste des Vlans
@stop

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Liste des Vlans
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card card-flush">
                <div class="card-header mt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
                            <input type="text" data-kt-permissions-table-filter="search" class="form-control form-control border border-gray-300 w-250px ps-13" placeholder="Recherche" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('vlan.create.show') }}">
                            <button type="button" class="btn btn-light-primary">
                                <i class="ki-duotone ki-plus-square fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                Ajouter un Vlan
                            </button>
                        </a>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div id="kt_permissions_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                        <div id="" class="table-responsive">
                            <<table class="table align-middle table-row-bordered fs-6 gy-5 mb-0 dataTable" id="kt_permissions_table" style="width: 100%;">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0" role="row">
                                        <th class="min-w-125px">Nom</th>
                                        <th class="min-w-125px">Numéro</th>
                                        <th class="min-w-125px">IP Début</th>
                                        <th class="min-w-125px">IP Fin</th>
                                        <th class="min-w-125px">Masque</th>
                                        <th class="min-w-125px">DHCP</th>
                                        <th class="min-w-125px">Crée le</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600 border-top">
                                    @foreach($vlans as $vlan)
                                    <tr>
                                        <td>{{ $vlan->nom }}</td>
                                        <td>{{ $vlan->num_vlan }}</td>
                                        <td>{{ $vlan->ip_debut }}</td>
                                        <td>{{ $vlan->ip_fin }}</td>
                                        <td>{{ $vlan->masque }}</td>
                                        <td>{{ $vlan->is_dhcp ? 'Oui' : 'Non' }}</td>
                                        <td>
                                            @if($vlan->created_at) 
                                                {{ $vlan->created_at->format('d/m/Y H:i') }} 
                                            @else 
                                                - 
                                            @endif
                                        </td>
                                        <td class="text-end">
                                        <a href="{{ route('it.vlan.show', ['id' => $vlan->id]) }}">
                                                <button class="btn btn-icon btn-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route('vlan.supprimer', ['id' => $vlan->id]) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce VLAN ?')">
                                                <button class="btn btn-icon btn-light-danger w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                                    <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="" class="row">
                            {!! $vlans->links('vendor.pagination.kevinPagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
