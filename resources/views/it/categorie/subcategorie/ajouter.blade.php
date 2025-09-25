@extends('layouts.app') 

@section('title')
Ajouter une Sous-Catégorie
@stop
@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                Ajouter une Sous-Catégorie
                </h1>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column flex-xl-row">
                <div class="card bg-body me-xl-9 mb-9 mb-xl-0" style="width:75%">
                    <div class="card-body">
                        <form action="{{ route('categorie.subcategory.create.show') }}" class="form mb-15" method="post" id="kt_careers_form" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-7">
                                <p class="fw-semibold fs-4 text-gray-600 mb-2">
                                    Ajouter une Sous-Catégorie à la liste des Sous-Catégories
                                </p>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Nom de la Sous-Catégorie</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_subcategory" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Modéle</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_modele" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Marque</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_marque" />
                                </div>
                            </div>
                            
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Fournisseur</label>
                                    <select class="form-control form-control border border-gray-300" name="id_fournisseur">
                                        @foreach ($fournisseurs as $fournisseur )
                                            <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Categorie</label>
                                    <select class="form-control form-control border border-gray-300" name="id_categorie">
                                        @foreach ($categories as $categorie )
                                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold mb-2"> Photo de l'équipement</label>
                                    <input class="form-control" type="file" name="photo" />
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
@stop
