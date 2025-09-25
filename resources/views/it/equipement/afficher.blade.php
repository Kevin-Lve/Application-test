@extends('layouts.app') 
@section('title')
Détails Équipement - {{ $equipement->hostname }}
@stop

@section('content')
<style>
    .equipment-image {
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 10px;
        min-height: 250px;
        background-color: #f8f9fa;
    }
    .info-card {
        border-left: 3px solid #3E97FF;
        transition: all 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .badge-vlan {
        background-color: #F1416C;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .equipment-image {
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      border-radius: 10px;
      min-height: 250px;
      background-color: #f8f9fa;
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .equipment-image:hover {
      transform: scale(1.05);
      z-index: 10;
      position: relative;
    }
    
    
</style>

<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Détails de l'équipement
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard.show') }}" class="text-muted text-hover-primary">Accueil</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('equipement.show.index') }}" class="text-muted text-hover-primary">Équipements</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $equipement->hostname }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('equipement.edit.show', ['id' => $equipement->id]) }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="ki-duotone ki-pencil fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <!--begin::Header Card-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin::Image-->
                        <div class="me-7 mb-4">
                            <div class="equipment-image" 
                                 style="background-image: url('/storage/photo_equipement/{{ $equipement->sous_categorie->file_path }}'); 
                                        width: 600px; 
                                        height: 450px;">
                            </div>
                        </div>
                        <!--end::Image-->

                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="text-gray-900 fs-2 fw-bold me-3">{{ $equipement->hostname }}</span>
                                        @if($equipement->action)
                                          @php
                                             $badgeClass = match($equipement->action->nom ?? '') {
                                                   'En stock' => 'badge-light-primary',
                                                   'Assigné' => 'badge-light-success', 
                                                   'En maintenance' => 'badge-light-warning',
                                                   'Hors service' => 'badge-light-danger',
                                                   'En transit' => 'badge-light-info',
                                                   'À retourner' => 'badge-light-secondary',
                                                   'Obsolète' => 'badge-light-dark',
                                                   'En commande' => 'badge-light-primary',
                                                   default => 'badge-light-secondary'
                                             };
                                          @endphp
                                          <span class="badge {{ $badgeClass }}">{{ $equipement->action->nom }}</span>
                                       @else
                                          <span class="badge badge-light-secondary">Aucun statut</span>
                                       @endif
                                    </div>
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <span class="d-flex align-items-center text-gray-500 mb-2 me-4">
                                            <i class="ki-duotone ki-tag fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            Numéro de série: {{ $equipement->numero_serie ?? 'N/A' }}
                                        </span>
                                        <span class="d-flex align-items-center text-gray-500 mb-2">
                                            <i class="ki-duotone ki-calendar fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Ajouté le: {{ $equipement->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-element-11 fs-3 text-primary me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                                <div class="fs-2 fw-bold">{{ $equipement->sous_categorie->categorie->nom }}</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-500">Catégorie</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-abstract-26 fs-3 text-warning me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold">{{ $equipement->sous_categorie->nom }}</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-500">Sous-catégorie</div>
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-abstract-41 fs-3 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold">{{ $equipement->sous_categorie->modele }}</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-500">Modèle</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                </div>
            </div>
            <!--end::Header Card-->

            <div class="row g-5 g-xl-10">
                <!--begin::Informations Réseau-->
                @if($equipement->adresse_ip)
                <div class="col-xl-6">
                    <div class="card info-card h-100">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Informations Réseau</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Configuration IP et réseau</span>
                            </h3>
                            <div class="card-toolbar">
                                <i class="ki-duotone ki-wifi-home fs-2x text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="table-responsive">
                                <table class="table table-row-bordered gy-5">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted fw-semibold">Adresse IP</td>
                                            <td class="text-end">
                                                <span class="badge badge-light-primary fs-7 fw-bold">{{ $equipement->adresse_ip }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-semibold">Adresse MAC</td>
                                            <td class="text-end">
                                                <span class="text-gray-900 fw-bold">{{ $equipement->adresse_mac ?? 'Non défini' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-semibold">VLAN</td>
                                            <td class="text-end">
                                                @if($equipement->vlan)
                                                    <span class="badge badge-light-info">{{ $equipement->vlan->nom }}</span>
                                                @else
                                                    <span class="text-muted">Non assigné</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-semibold">Statut connexion</td>
                                            <td class="text-end">
                                                <span class="badge badge-light-success">En ligne</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!--end::Informations Réseau-->

                <!--begin::Informations Fournisseur-->
                <div class="col-xl-6">
                    <div class="card info-card h-100">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Fournisseur</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">{{ $equipement->sous_categorie->fournisseur->nom }}</span>
                            </h3>
                            <div class="card-toolbar">
                                <i class="ki-duotone ki-shop fs-2x text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <div class="symbol symbol-150px mb-5">
                                    <img src="/storage/photo_fournisseur/{{ $equipement->sous_categorie->fournisseur->image}}" 
                                         alt="{{ $equipement->sous_categorie->fournisseur->nom }}"
                                         class="img-fluid rounded"/>
                                </div>
                                <div class="text-center">
                                    <h4 class="fw-bold text-gray-900 mb-1">{{ $equipement->sous_categorie->fournisseur->nom }}</h4>
                                    @if($equipement->sous_categorie->fournisseur->email)
                                        <div class="text-muted mb-2">{{ $equipement->sous_categorie->fournisseur->email }}</div>
                                    @endif
                                    @if($equipement->sous_categorie->fournisseur->telephone)
                                        <div class="text-muted">{{ $equipement->sous_categorie->fournisseur->telephone }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Informations Fournisseur-->
            </div>

            <!--begin::Attribution Row-->
            @php
                $attribution = null;
                $attributionType = null;
                
                if ($equipement->type_attribution === 'utilisateur' && $equipement->id_attribution) {
                    $attribution = \App\Models\User::find($equipement->id_attribution);
                    $attributionType = 'Utilisateur';
                } elseif ($equipement->type_attribution === 'service' && $equipement->id_attribution) {
                    $attribution = \App\Models\Gestion\Service::find($equipement->id_attribution);
                    $attributionType = 'Service';
                }
            @endphp

            @if($attribution)
            <div class="row g-5 g-xl-10 mt-1">
                <div class="col-xl-6">
                    <div class="card info-card h-100">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">{{ $attributionType }}</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Assigné à</span>
                            </h3>
                            <div class="card-toolbar">
                                <i class="ki-duotone ki-user fs-2x text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <div class="symbol symbol-100px mb-5">
                                    @if($attributionType === 'Utilisateur')
                                        <span class="symbol-label bg-light-primary text-primary fs-1 fw-bold">
                                            {{ strtoupper(substr($attribution->prenom, 0, 1) . substr($attribution->nom, 0, 1)) }}
                                        </span>
                                    @else
                                        <span class="symbol-label bg-light-success text-success fs-1 fw-bold">
                                            {{ strtoupper(substr($attribution->nom, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    @if($attributionType === 'Utilisateur')
                                        <h4 class="fw-bold text-gray-900 mb-1">{{ $attribution->prenom }} {{ $attribution->nom }}</h4>
                                        @if($attribution->email)
                                            <div class="text-muted mb-2">{{ $attribution->email }}</div>
                                        @endif
                                    @else
                                        <h4 class="fw-bold text-gray-900 mb-1">{{ $attribution->nom }}</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!--end::Attribution Row-->

            <!--begin::Informations supplémentaires-->
            <div class="row g-5 g-xl-10 mt-1">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Informations supplémentaires</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Détails complets de l'équipement</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($equipement->emplacement)
                                <div class="col-md-6 mb-5">
                                    <label class="fw-semibold text-muted fs-6 mb-2">Emplacement</label>
                                    <p class="fw-bold text-gray-900 fs-6">{{ $equipement->emplacement->nom }}</p>
                                </div>
                                @endif
                                
                                @if($equipement->date_achat)
                                <div class="col-md-6 mb-5">
                                    <label class="fw-semibold text-muted fs-6 mb-2">Date d'achat</label>
                                    <p class="fw-bold text-gray-900 fs-6">{{ $equipement->date_achat->format('d/m/Y') }}</p>
                                </div>
                                @endif
                                
                                @if($equipement->prix)
                                <div class="col-md-6 mb-5">
                                    <label class="fw-semibold text-muted fs-6 mb-2">Prix</label>
                                    <p class="fw-bold text-gray-900 fs-6">{{ number_format($equipement->prix, 2) }} €</p>
                                </div>
                                @endif
                                
                                @if($equipement->description)
                                <div class="col-12">
                                    <label class="fw-semibold text-muted fs-6 mb-2">Description</label>
                                    <p class="fw-bold text-gray-900 fs-6">{{ $equipement->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Informations supplémentaires-->

        </div>
    </div>
    <!--end::Content-->
</div>
@stop