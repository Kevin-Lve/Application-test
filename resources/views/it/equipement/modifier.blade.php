@extends('layouts.app') 
@section('title')
Modifier un Equipement
@stop
@section('content')
				<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
					Modifier un Equipement
				</h1>
			</div>
		</div>
	</div>
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<div id="kt_app_content_container" class="app-container container-fluid">
			<div class="d-flex flex-column flex-xl-row">
				<div class="card bg-body me-xl-9 mb-9 mb-xl-0" style="width:75%">
					<div class="card-body">
						<form action="{{ route('equipement.edit', ['id' => $equipement->id]) }}" class="form mb-15" method="post" id="kt_careers_form">
							@csrf
							<div class="mb-7">
								<p class="fw-semibold fs-4 text-gray-600 mb-2">
									Modifier un équipement
								</p>
							</div>
							<!-- Sous-Catégorie -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Sous-Catégorie</label>
									<select class="form-control form-control border border-gray-300" name="id_sous_categorie">
                                        @foreach ($sous_categories as $sous_categorie)
                                            @if($equipement->id_sous_categorie == $sous_categorie->id)
                                                <option value="{{ $sous_categorie->id }}" selected>{{ $sous_categorie->nom }}</option>
                                            @else 
                                                <option value="{{ $sous_categorie->id }}">{{ $sous_categorie->nom }}</option>
                                            @endif
                                        @endforeach
									</select>
								</div>
							</div>
							<!-- Emplacement -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Emplacement</label>
									<select class="form-control form-control border border-gray-300" name="id_emplacement">
                                        @foreach ($emplacements as $emplacement)
                                            @if($equipement->id_emplacement == $emplacement->id)
                                                <option value="{{ $emplacement->id }}">{{ $emplacement->nom }}</option>
                                            @else 
                                                <option value="{{ $emplacement->id }}">{{ $emplacement->nom }}</option>
                                            @endif
                                        @endforeach
									</select>
								</div>
							</div>
							<!-- Type d'Attribution -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row block">
									<label class="required fs-5 fw-semibold mb-2">Type d'attribution</label>
									<div class="mt-4">
										<input class="form-check-input choix_attribution_btn" type="radio" name="type_attribution" value="service" @if($equipement->type_attribution == 'service') checked @endif>
										<span class="form-check-label text-gray-600">Service</span>
									</div>
									<div class="mt-4">
										<input class="form-check-input choix_attribution_btn" type="radio" name="type_attribution" value="utilisateur" @if($equipement->type_attribution == 'utilisateur') checked @endif>
										<span class="form-check-label text-gray-600">Utilisateur</span>
									</div>
								</div>
							</div>
							<!-- Dropdown dynamique pour Service ou Utilisateur -->
							<div class="row mb-5" id="select_service" @if($equipement->type_attribution !== 'service') style="display:none" checked @endif>
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Service</label>
									<select class="form-control form-control border border-gray-300" name="id_service">
										@foreach ($services as $service )
										<option value="{{ $service->id }}">{{ $service->nom }}</option>
										@endforeach
                                        @foreach ($services as $service)
                                            @if($equipement->id_attribution == $service->id)
                                                <option value="{{ $service->id }}" selected>{{ $service->nom }}</option>
                                            @else 
                                                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                            @endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="row mb-5" id="select_utilisateur" @if($equipement->type_attribution !== 'utilisateur') style="display:none" checked @endif>
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Utilisateur</label>
									<select class="form-control form-control border border-gray-300" name="id_utilisateur">
                                        @foreach ($users as $user)
                                            @if($equipement->id_attribution == $user->id)
                                                <option value="{{ $user->id }}" selected>{{ $user->prenom }} {{ $user->nom }}</option>
                                            @else 
                                                <option value="{{ $user->id }}">{{ $user->prenom }} {{ $user->nom }}</option>
                                            @endif
										@endforeach
									</select>
								</div>
							</div>
							<!-- Numéro de Serie -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Numéro de Serie</label>
									<input type="text" value="{{ $equipement->numero_serie }}" class="form-control form-control border border-gray-300" placeholder="" name="sn" />
								</div>
							</div>
							<!-- Prix -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Prix</label>
									<input type="text" value="{{ $equipement->prix }}" class="form-control form-control border border-gray-300" placeholder="" name="prix" />
								</div>
							</div>
							<!-- Description -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Description</label>
									<input type="text" value="{{ $equipement->description }}" class="form-control form-control border border-gray-300" placeholder="" name="description" />
								</div>
							</div>
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Date Achat</label>
									<input type="date" value="{{ optional($equipement->date_achat)->format('Y-m-d') }}" class="form-control form-control border border-gray-300" name="date_achat" />
								</div>
							</div>
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Date Obsolescence</label>
									<input type="date" value="{{ optional($equipement->date_obsolescence)->format('Y-m-d') }}" class="form-control form-control border border-gray-300" name="date_obsolescence" />
								</div>
							</div>
							<!-- Équipement Réseau - Oui / Non -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row block">
									<label class="required fs-5 fw-semibold mb-2">Équipement Réseau ?</label>
									<div class="mt-4">
										<input class="form-check-input choix_equipement_reseau" type="radio" name="equipement_reseau" value="oui" @if($equipement->adresse_ip) checked @endif>
										<span class="form-check-label text-gray-600">Oui</span>
									</div>
									<div class="mt-4">
										<input class="form-check-input choix_equipement_reseau" type="radio" name="equipement_reseau" value="non" @if(!$equipement->adresse_ip) checked @endif>
										<span class="form-check-label text-gray-600">Non</span>
									</div>
								</div>
							</div>
							<!-- Champs Réseau -->
							<div id="network_fields" @if(!$equipement->adresse_ip) style="display:none"  @endif>
								<div class="row mb-5">
									<div class="col-md-6 fv-row">
										<label class="required fs-5 fw-semibold mb-2">VLAN</label>
										<select class="form-control form-control border border-gray-300" name="id_vlan">
											<option value="">Choisir une option</option>
											@foreach ($vlans as $vlan )
                                                @if($equipement->id_vlan == $vlan->id)
											    <option value="{{ $vlan->id }}" selected>{{ $vlan->nom }}</option>
                                                @else 
											    <option value="{{ $vlan->id }}">{{ $vlan->nom }}</option>
                                                @endif
											@endforeach
										</select>
									</div>
								</div>
								<div class="row mb-5">
									<div class="col-md-6 fv-row">
										<label class="required fs-5 fw-semibold mb-2">IP</label>
										<input type="text" value="{{ $equipement->adresse_ip }}" class="form-control form-control border border-gray-300" placeholder="" name="adresse_ip" />
									</div>
								</div>
								<div class="row mb-5">
									<div class="col-md-6 fv-row">
										<label class="required fs-5 fw-semibold mb-2">Mac</label>
										<input type="text" value="{{ $equipement->adresse_mac }}" class="form-control form-control border border-gray-300" placeholder="" name="adresse_mac" />
									</div>
								</div>
							</div>
							<div class="separator mb-8"></div>
							<button type="submit" class="btn btn-primary" id="kt_careers_submit_button">
							<span class="indicator-label">Modifier</span>
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
	
	    $('.choix_equipement_reseau').on('change', function(){
	        if($(this).val() == 'oui'){
	            $('#network_fields').show();
	        } else {
	            $('#network_fields').hide();
	        }
	    });
	});
</script>
@stop
