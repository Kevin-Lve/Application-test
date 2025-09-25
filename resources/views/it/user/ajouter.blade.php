@extends('layouts.app') 

@section('title')
Ajouter un Utilisateur
@stop
@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Ajouter un Utilisateur
                </h1>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column flex-xl-row">
                <div class="card bg-body me-xl-9 mb-9 mb-xl-0" style="width:75%">
                    <div class="card-body">
                        <form action="{{ route('user.create') }}" class="form mb-15" method="post" id="kt_careers_form">
                            @csrf
                            <div class="mb-7">
                                <p class="fw-semibold fs-4 text-gray-600 mb-2">
                                    Ajouter un utilisateur à la liste des utilisateurs
                                </p>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Nom</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="nom_user" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Prénom</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="prenom_user" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">E-mail</label>
                                    <input type="text" class="form-control form-control border border-gray-300" placeholder="" name="email_user" />
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Service</label>
                                    <select class="form-control form-control border border-gray-300" name="id_service">
                                    <option value="NULL">Choisir une option</option>
                                        @foreach ($services as $service )
                                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>    
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Rôle</label>
                                    <select class="form-control form-control border border-gray-300" name="id_role">
                                    <option value="NULL">Choisir une option</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->nom }}</option>
                                        @endforeach
                                    </select>
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
