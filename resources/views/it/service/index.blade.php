@extends('layouts.app') @section('title') Liste des services @stop @section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Liste des services
                </h1>
            </div>
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Card-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
                            <input type="text" data-kt-permissions-table-filter="search" class="form-control form-control border border-gray-300 w-250px ps-13" placeholder="Rechercher" />
                        </div>
                    </div>

                    <div class="card-toolbar">
                        <a href="{{ route('service.create.show') }}">
                            <button type="button" class="btn btn-light-primary">
                                <i class="ki-duotone ki-plus-square fs-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                Ajouter un service
                            </button>
                        </a>
                    </div>
                </div>

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div id="kt_permissions_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                        <div id="" class="table-responsive">
                            <table class="table align-middle table-row-bordered fs-6 gy-5 mb-0 dataTable" id="kt_permissions_table" style="width: 100%;">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0" role="row">
                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc">
                                            <span class="dt-column-title" role="button">Nom</span>
                                        </th>
                                        <th class="min-w-125px dt-orderable-asc dt-orderable-desc">
                                            <span class="dt-column-title" role="button">Crée le</span>
                                        </th>
                                        <th class="text-end min-w-100px dt-orderable-none" data-dt-column="3" rowspan="1" colspan="1" aria-label="Actions">
                                            <span class="dt-column-title">Actions</span><span class="dt-column-order"></span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600 border-top">
                                    @foreach($services as $service)
                                    <tr>
                                        <td>{{ $service->nom }}</td>
                                        <td>
                                            @if($service->created_at) {{ $service->created_at }} @else - @endif
                                        </td>
                                        <td class="text-end">
                                          <a href="{{ route('it.service.show', ['id' => $service->id]) }}">
                                                <button class="btn btn-icon btn-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </a>
                                            </button>
                                            <a href="{{ route('supprimer.service', ['id' => $service->id]) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce Service ?')">
                                            <button class="btn btn-icon btn-light-danger w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                                <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <div id="" class="row">
                            {!! $services->links('vendor.pagination.kevinPagination') !!}
                        </div>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->


            <!--end::Modal - Update permissions--><!--end::Modals-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
@stop
