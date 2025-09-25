@extends('layouts.app') 
@section('title')
Afficher Une Sous_Categorie
@stop
@section('content')
<div class="d-flex flex-column flex-column-fluid">
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
<!--begin::Toolbar container-->
<div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
   <!--begin::Content-->
   <div id="kt_app_content" class="app-content  flex-column-fluid ">
      <!--begin::Content container-->
      <div id="kt_app_content_container" class="app-container  container-xxl ">
         <!--begin::Order details page-->
         <div class="d-flex flex-column gap-7 gap-lg-10">
            <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
               <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                  <!--begin::Title-->
                  <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                     Nom : {{ $sous_categorie->nom }}</br>
                
                  </h1>
               </div>
               
               <a href="{{ route('sous_categorie.edit', ['id' => $sous_categorie->id]) }}" class="btn btn-success btn-sm me-lg-n7">Modifier</a>
               
            </div>
            <!--begin::Order summary-->
            <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
               <!--begin::Order details-->
               <style>
                  .bg-contain {
                  background-size: contain; /* Scales the image to fit within the div, maintaining aspect ratio */
                  background-position: center center; /* Centers the image in both directions */
                  background-repeat: no-repeat; /* Prevents the image from repeating */
                  overflow: hidden; /* Ensures no overflow */
                  border-radius: 5px; /* Optional rounded corners */
                  }
               </style>
               <div class="card card-flush py-4 flex-row-fluid  bg-contain mx-auto">
                  <!--end::Card header-->
                  <!--begin::Card body-->
                  <div class="card-body pt-0 bg-contain mx-auto"
                     style="background-image: url('/storage/photo_equipement/{{ $sous_categorie->file_path }}'); width: 300px; height: 200px;"></div>
                  <!--end::Card body-->
               </div>
               <!--end::Order details-->
               <!--begin::Customer details-->
               <div class="card card-flush py-4  flex-row-fluid">
                  <!--begin::Card header-->
                  <div class="card-header">
                     <div class="card-title">
                        <h2>Catégorie</h2>
                     </div>
                  </div>
                  <!--end::Card header-->
                  <!--begin::Card body-->
                  <div class="card-body pt-0">
                     <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed mb-0 fs-6 gy-5 min-w-300px">
                           <tbody class="fw-semibold text-gray-600 border-top">
                              <tr>
                                 <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                       Catégorie
                                    </div>
                                 </td>
                                 <td class="fw-bold text-end">
                                    <span class="text-gray-600 text-hover-primary">
                                    {{ $sous_categorie->categorie->nom }}
                                    </span>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                       Sous-Catégorie
                                    </div>
                                 </td>
                                 <td class="fw-bold text-end">
                                    <span class="text-gray-600 text-hover-primary">
                                    {{ $sous_categorie->nom }}
                                    </span>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                       Modèle
                                    </div>
                                 </td>
                                 <td class="fw-bold text-end">
                                    <span class="text-gray-600 text-hover-primary">
                                    {{ $sous_categorie->modele }}
                                    </span>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                        <!--end::Table-->
                     </div>
                  </div>
                  <!--end::Card body-->
               </div>

               
               <!--end::Customer details-->
               <!--begin::Documents-->
               <div class="card card-flush py-4  flex-row-fluid">
                  <!--begin::Card header-->
                  <div class="card-header">
                     <div class="card-title">
                        <h2>Fournisseur : {{ $sous_categorie->fournisseur->nom }}</h2>
                     </div>
                  </div>
                  <!--end::Card header-->
                  <!--begin::Card body-->
                  <div class="card-body pt-0">
                     <div class="bg-contain mx-auto" style="background-image: url('/storage/photo_fournisseur/{{ $sous_categorie->fournisseur->image}}'); width: 300px; height: 200px;"></div>
                  </div>
                  <!--end::Card body-->
               </div>
               <!--end::Documents-->    
            </div>
            <!--end::Order summary-->
            <!--begin::Tab content-->
            <div class="tab-content">
               <!--begin::Tab pane-->
               <!--begin::Tab pane-->
               <div class="tab-pane fade active show" id="kt_ecommerce_sales_order_history" role="tab-panel">
                  <!--begin::Orders-->
                  <div class="d-flex flex-column gap-7 gap-lg-10">



                     <!--end::Order data-->            
                  </div>
                  <!--end::Orders-->
               </div>
               <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
         </div>
         <!--end::Order details page-->        
      </div>
      <!--end::Content container-->
   </div>
   <!--end::Content-->	
</div>
@stop
