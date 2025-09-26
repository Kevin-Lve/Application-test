@extends('layouts.app')

@section('title', 'Modifier un équipement')

@section('content')
@php
    $attributeErrors = collect($errors->getMessages())
        ->filter(fn ($messages, $key) => \Illuminate\Support\Str::startsWith($key, 'attributs.'))
        ->mapWithKeys(function ($messages, $key) {
            $id = (int) str_replace('attributs.', '', $key);
            return [$id => $messages];
        });
    $reseau = old('equipement_reseau', $equipement->adresse_ip ? 'oui' : 'non');
    $type = old('type_attribution', $equipement->type_attribution ?? 'service');
@endphp
<div class="d-flex flex-column flex-column-fluid" data-module="form-dynamic assign-equipment search-autocomplete">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Modifier l'équipement
                </h1>
                <span class="fs-6 text-muted">Adapte la fiche, les attributs dynamiques et l'attribution en conservant un audit trail propre.</span>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column flex-xl-row">
                <div class="card bg-body me-xl-9 mb-9 mb-xl-0 flex-grow-1">
                    <div class="card-body">
                        <form method="POST" action="{{ route('equipement.edit', ['id' => $equipement->id]) }}" class="form" data-dynamic-form data-assign-form
                              data-requires-comment="true"
                              data-category-endpoint="{{ url('api/categories') }}"
                              data-attribute-endpoint="{{ url('api/sous-categories') }}"
                              data-initial-category="{{ $selectedCategoryId }}"
                              data-initial-subcategory="{{ $selectedSousCategorieId }}"
                              data-old-attributes='@json(old('attributs', []))'
                              data-existing-attributes='@json($existingAttributeValues)'
                              data-attribute-errors='@json($attributeErrors)'
                              data-initial-type="{{ $equipement->type_attribution ?? 'service' }}"
                              data-initial-action="{{ $equipement->id_action }}"
                              data-initial-target="{{ $equipement->id_attribution ?? '' }}">
                            @csrf

                            <div class="mb-7">
                                <p class="fw-semibold fs-4 text-gray-600 mb-2">
                                    Les champs réseau et dynamiques s'adaptent automatiquement ; seuls les changements sensibles requièrent un commentaire.
                                </p>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Catégorie</label>
                                    <select class="form-control border border-gray-300" name="id_categorie" data-category-select>
                                        <option value="">Choisir une catégorie</option>
                                        @foreach ($categories as $categorie)
                                            <option value="{{ $categorie->id }}" @selected((string) $selectedCategoryId === (string) $categorie->id)>{{ $categorie->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_categorie')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Sous-catégorie</label>
                                    <select class="form-control border border-gray-300" name="id_sous_categorie" data-subcategory-select>
                                        <option value="">Sélectionne une sous-catégorie</option>
                                        @foreach ($categories->firstWhere('id', $selectedCategoryId)?->sousCategories ?? [] as $sousCategorie)
                                            <option value="{{ $sousCategorie->id }}" @selected((string) $selectedSousCategorieId === (string) $sousCategorie->id)>{{ $sousCategorie->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_sous_categorie')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Emplacement</label>
                                    <select class="form-control border border-gray-300" name="id_emplacement">
                                        <option value="">Choisir un emplacement</option>
                                        @foreach ($emplacements as $emplacement)
                                            <option value="{{ $emplacement->id }}" @selected(old('id_emplacement', $equipement->id_emplacement) == $emplacement->id)>{{ $emplacement->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_emplacement')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Statut / action matériel</label>
                                    <select class="form-control border border-gray-300" name="id_action" data-action-select>
                                        <option value="">Choisir un statut</option>
                                        @foreach ($actions as $action)
                                            <option value="{{ $action->id }}" @selected(old('id_action', $equipement->id_action) == $action->id)>{{ $action->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_action')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row block">
                                    <label class="required fs-5 fw-semibold mb-2">Type d'attribution</label>
                                    <div class="d-flex flex-wrap gap-4 mt-3">
                                        <label class="form-check form-check-custom form-check-solid align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="type_attribution" value="service" {{ $type === 'service' ? 'checked' : '' }}>
                                            <span class="form-check-label text-gray-600">Service</span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-solid align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="type_attribution" value="utilisateur" {{ $type === 'utilisateur' ? 'checked' : '' }}>
                                            <span class="form-check-label text-gray-600">Utilisateur</span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-solid align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="type_attribution" value="stock" {{ $type === 'stock' ? 'checked' : '' }}>
                                            <span class="form-check-label text-gray-600">Stock</span>
                                        </label>
                                    </div>
                                    @error('type_attribution')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5" data-attribution-section="service" @if($type !== 'service') hidden @endif>
                                <div class="col-md-6 fv-row position-relative" data-autocomplete>
                                    <label class="fs-5 fw-semibold mb-2">Service</label>
                                    <input type="hidden" name="id_service" value="{{ old('id_service', $selectedServiceId) }}" data-autocomplete-hidden>
                                    <input type="search" class="form-control border border-gray-300" placeholder="Recherche service" data-autocomplete-input data-autocomplete-endpoint="{{ route('api.search.services') }}" value="{{ $selectedServiceLabel }}" autocomplete="off">
                                    <div class="autocomplete-menu list-group position-absolute top-100 start-0 w-100 shadow-sm mt-1" data-autocomplete-results hidden></div>
                                    <small class="text-muted">Tape au moins deux caractères pour filtrer les services.</small>
                                    @error('id_service')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5" data-attribution-section="utilisateur" @if($type !== 'utilisateur') hidden @endif>
                                <div class="col-md-6 fv-row position-relative" data-autocomplete>
                                    <label class="fs-5 fw-semibold mb-2">Utilisateur</label>
                                    <input type="hidden" name="id_utilisateur" value="{{ old('id_utilisateur', $selectedUserId) }}" data-autocomplete-hidden>
                                    <input type="search" class="form-control border border-gray-300" placeholder="Recherche utilisateur" data-autocomplete-input data-autocomplete-endpoint="{{ route('api.search.users') }}" value="{{ $selectedUserLabel }}" autocomplete="off">
                                    <div class="autocomplete-menu list-group position-absolute top-100 start-0 w-100 shadow-sm mt-1" data-autocomplete-results hidden></div>
                                    <small class="text-muted">Nom, prénom ou email.</small>
                                    @error('id_utilisateur')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Numéro de série</label>
                                    <input type="text" class="form-control border border-gray-300" name="sn" value="{{ old('sn', $equipement->numero_serie) }}" />
                                    @error('sn')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Hostname</label>
                                    <input type="text" class="form-control border border-gray-300" name="hostname" value="{{ old('hostname', $equipement->hostname) }}" />
                                    @error('hostname')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Prix</label>
                                    <input type="number" step="0.01" class="form-control border border-gray-300" name="prix" value="{{ old('prix', $equipement->prix) }}" />
                                    @error('prix')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Description</label>
                                    <input type="text" class="form-control border border-gray-300" name="description" value="{{ old('description', $equipement->description) }}" />
                                    @error('description')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Date d'achat</label>
                                    <input type="date" class="form-control border border-gray-300" name="date_achat" value="{{ old('date_achat', optional($equipement->date_achat)->format('Y-m-d')) }}" />
                                    @error('date_achat')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Date d'obsolescence</label>
                                    <input type="date" class="form-control border border-gray-300" name="date_obsolescence" value="{{ old('date_obsolescence', optional($equipement->date_obsolescence)->format('Y-m-d')) }}" />
                                    @error('date_obsolescence')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6 fv-row block">
                                    <label class="required fs-5 fw-semibold mb-2">Équipement réseau ?</label>
                                    <div class="d-flex gap-4 mt-3">
                                        <label class="form-check form-check-custom form-check-solid align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="equipement_reseau" value="oui" data-network-toggle {{ $reseau === 'oui' ? 'checked' : '' }}>
                                            <span class="form-check-label text-gray-600">Oui</span>
                                        </label>
                                        <label class="form-check form-check-custom form-check-solid align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="equipement_reseau" value="non" data-network-toggle {{ $reseau !== 'oui' ? 'checked' : '' }}>
                                            <span class="form-check-label text-gray-600">Non</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="border rounded p-5 mb-5" data-network-fields @if($reseau !== 'oui') hidden @endif>
                                <h5 class="fw-bold text-primary mb-4">Informations réseau</h5>
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">VLAN</label>
                                        <select class="form-control border border-gray-300" name="id_vlan">
                                            <option value="">Choisir un VLAN</option>
                                            @foreach ($vlans as $vlan)
                                                <option value="{{ $vlan->id }}" @selected(old('id_vlan', $equipement->id_vlan) == $vlan->id)>{{ $vlan->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_vlan')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">Adresse IP</label>
                                        <input type="text" class="form-control border border-gray-300" name="adresse_ip" value="{{ old('adresse_ip', $equipement->adresse_ip) }}" />
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <label class="fs-5 fw-semibold mb-2">Adresse MAC</label>
                                        <input type="text" class="form-control border border-gray-300" name="adresse_mac" value="{{ old('adresse_mac', $equipement->adresse_mac) }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-8" data-attribute-container>
                                <div class="alert alert-secondary mb-0">
                                    Les attributs spécifiques apparaîtront selon la sous-catégorie sélectionnée.
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-8 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Commentaire (obligatoire si changement)</label>
                                    <textarea class="form-control border border-gray-300" name="commentaire" rows="3" data-comment-field placeholder="Explique le contexte de la modification.">{{ old('commentaire') }}</textarea>
                                    @error('commentaire')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="separator mb-8"></div>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Mettre à jour</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
