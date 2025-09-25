@extends('layouts.app') 

@section('title')
Ajouter un Equipement
@stop
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Ajouter un Equipement
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column flex-xl-row">
                <div class="card bg-body me-xl-9 mb-9 mb-xl-0" style="width:75%">
                    <div class="card-body">
                        <form action="{{ route('equipement.create.show') }}" class="form mb-15" method="post" id="kt_careers_form">
                            @csrf
                            <div class="mb-7">
                                <p class="fw-semibold fs-4 text-gray-600 mb-2">
                                    Ajouter un Equipement à la liste des Equipements
                                </p>
                            </div>

                            <!-- Sous-Catégorie -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Sous-Catégorie</label>
                                    <select class="form-control form-control border border-gray-300" name="id_sous_categorie">
                                        @foreach ($sous_categories as $sous_categorie )
                                            <option value="{{ $sous_categorie->id }}">{{ $sous_categorie->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Emplacement -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Emplacement</label>
                                    <select class="form-control form-control border border-gray-300" name="id_emplacement">
                                    <option value="NULL">Choisir une option</option>
                                        @foreach ($emplacements as $emplacement )
                                            <option value="{{ $emplacement->id }}">{{ $emplacement->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <!-- Type d'Attribution -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row block">
                                    <label class="required fs-5 fw-semibold mb-2">Type d'attribution</label>
                                    <div class="mt-4">
                                        <input class="form-check-input choix_attribution_btn" type="radio" checked name="type_attribution" value="service">
                                        <span class="form-check-label text-gray-600">Service</span>
                                    </div>
                                    <div class="mt-4">
                                        <input class="form-check-input choix_attribution_btn" type="radio" name="type_attribution" value="utilisateur">
                                        <span class="form-check-label text-gray-600">Utilisateur</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Dropdown dynamique pour Service ou Utilisateur -->
                            <div class="row mb-5" id="select_service">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Service</label>
                                    <select class="form-control form-control border border-gray-300" name="id_service">
                                        @foreach ($services as $service )
                                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-5" id="select_utilisateur" style="display:none">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Utilisateur</label>
                                    <select class="form-control form-control border border-gray-300" name="id_utilisateur">
                                        @foreach ($users as $user )
                                            <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Numéro de Serie -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Numéro de Serie</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="sn" />
                                </div>
                            </div>
                            <!-- Hostname -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Hostname</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="ex: FRALSWLT0010" name="hostname" />
                                </div>
                            </div>
                            <!-- Hostname -->
                            <!-- Statut -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Statut</label>
                                    <select class="form-control form-control border border-gray-300" name="id_action">
                                    <option value="NULL">Choisir une option</option>
                                        @foreach ($actions as $action )
                                            <option value="{{ $action->id }}"
                                                {{ $action->nom === 'En stock' ? 'selected' : '' }}>
                                                {{ $action->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold-mb-2">Date Livraison</label>
                                    <input type="date" class="form-control form control-solid" name="date_livraison" />
                                </div>
                            </div>
                            <!-- Prix -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Prix</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="prix" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Description</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="description" />
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Date Achat</label>
                                    <input type="date" class="form-control form-control border border-gray-300" name="date_achat" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Date Obsolescence</label>
                                    <input type="date" class="form-control form-control border border-gray-300" name="date_obsolescence" />
                                </div>
                            </div>
                                         <!-- Équipement Réseau - Oui / Non -->
                                         <div class="row mb-5">
                                <div class="col-md-6 fv-row block">
                                    <label class="required fs-5 fw-semibold mb-2">Équipement Réseau ?</label>
                                    <div class="mt-4">
                                        <input class="form-check-input choix_equipement_reseau" type="radio" name="equipement_reseau" value="oui">
                                        <span class="form-check-label text-gray-600">Oui</span>
                                    </div>
                                    <div class="mt-4">
                                        <input class="form-check-input choix_equipement_reseau" type="radio" name="equipement_reseau" value="non" checked>
                                        <span class="form-check-label text-gray-600">Non</span>
                                    </div>
                                </div>
                            </div>



                            <!-- Champs Réseau -->
                            <div id="network_fields" style="display: none;">
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">VLAN</label>
                                        <select class="form-control form-control border border-gray-300" name="id_vlan">
                                            <option value="NULL">Choisir une option</option>
                                            @foreach ($vlans as $vlan )
                                                <option value="{{ $vlan->id }}">{{ $vlan->nom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">IP</label>
                                        <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="adresse_ip" />
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <label class="required fs-5 fw-semibold mb-2">Mac</label>
                                        <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="adresse_mac" />
                                    </div>
                                </div>
                                <!-- Champs Sim Hide -->
                                <div id="champs_sim" style="display: none;">
                                    <h5 class="fw-bold text-primary mb-3">Informations SIM</h5>
                                    <div class="row mb-5">
                                        <label class="fs-5 fw-semibold mb-2">Numéro télèphone/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="separator mb-8"></div>
                            <button type="submit" class="btn btn-primary" id="kt_careers_submit_button">
                                <span class="indicator-label">Ajouter</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Afficher le champ "Service" ou "Utilisateur" selon le choix de l'attribution
        $('.choix_attribution_btn').on('change', function(){
            var valeur_choisi = $(this).val();
            if(valeur_choisi == 'service'){
                $('#select_service').show();
                $('#select_utilisateur').hide();
            }else if(valeur_choisi == 'utilisateur'){
                $('#select_utilisateur').show();
                $('#select_service').hide();
            }
        });

        // Afficher ou cacher les champs réseau selon le choix de "Équipement Réseau"
        $('.choix_equipement_reseau').on('change', function(){
            if($(this).val() == 'oui'){
                $('#network_fields').show();
            } else {
                $('#network_fields').hide();
            }
        });
    });
    function test(){
        alert('Javascript fonctionne !')
    }
</script>
@stop
