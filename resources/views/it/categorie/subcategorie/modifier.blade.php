@extends('layouts.app') 
@section('title')
Modifier une Sous-Catégorie
@stop
@section('content')
<div>
    <div>
        <div>
            <div>
				<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
					Modifier une Sous-Catégorie
				</h1>
			</div>
		</div>
	</div>
	<div id="kt_app_content" class="app-content flex-column-fluid">
		<div id="kt_app_content_container" class="app-container container-fluid">
			<div class="d-flex flex-column flex-xl-row">
				<div class="card bg-body me-xl-9 mb-9 mb-xl-0" style="width:75%">
					<div class="card-body">
						<form action="{{ route('sous_categorie.edit', ['id' => $sous_categories->id]) }}" class="form mb-15" method="post" id="kt_careers_form">
							@csrf
							<div class="mb-7">
								<p class="fw-semibold fs-4 text-gray-600 mb-2">
									Modifier une Sous-Catégorie
								</p>
							</div>
							<!-- Numéro de Serie -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Nom</label>
									<input type="text" value="{{ $sous_categories->nom }}" class="form-control form-control border border-gray-300" placeholder="" name="nom" />
								</div>
							</div>
							<!-- Prix -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Modele</label>
									<input type="text" value="{{ $sous_categories->modele}}" class="form-control form-control border border-gray-300" placeholder="" name="modele" />
								</div>
							</div>
							<!-- Description -->
							<div class="row mb-5">
								<div class="col-md-6 fv-row">
									<label class="required fs-5 fw-semibold mb-2">Marque</label>
									<input type="text" value="{{ $sous_categories->marque}}" class="form-control form-control border border-gray-300" placeholder="" name="marque" />
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
@stop
