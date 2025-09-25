@extends('layouts.app') 

@section('title')
Ajouter un Vlan
@stop
@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Ajouter un Vlan
                </h1>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column flex-xl-row">
                <div class="card bg-body me-xl-9 mb-9 mb-xl-0" style="width:75%">
                    <div class="card-body">
                        <form action="{{ route('vlan.create') }}" class="form mb-15" method="post" id="kt_careers_form">
                            @csrf
                            <div class="mb-7">
                                <p class="fw-semibold fs-4 text-gray-600 mb-2">
                                    Ajouter un vlan à la liste des vlan
                                </p>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Nom du Vlan</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_vlan" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Numéro Vlan</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="num_vlan" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">IP Passerelle</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="passerelle_defaut" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">IP Début</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_ip_debut" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">IP Fin</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_ip_fin" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Masque</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_masque" />
                                </div>
                            </div>
                                <div class="mb-5">
                                    <label class="fs-5 fw-semibold mb-2">DHCP</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="nom_is_dhcp" value="1" id="nom_is_dhcp" onclick="updateDhcpStatus()">
                                        <label class="form-check-label" id="dhcpStatusLabel">Non</label>
                                    </div>
                                </div>

                                <div class="separator mb-8"></div>
                                <button type="submit" class="btn btn-primary" id="kt_careers_submit_button">
                                    <span class="indicator-label">Ajouter</span>
                                </button>

                                <script>
                                    function updateDhcpStatus() {
                                        const checkbox = document.getElementById("nom_is_dhcp");
                                        const label = document.getElementById("dhcpStatusLabel");

                                        // Change le texte selon l'état de la case
                                        label.textContent = checkbox.checked ? "Oui" : "Non";
                                    }
                                </script>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
