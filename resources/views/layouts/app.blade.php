<!DOCTYPE html>
<html lang="en" >
   <!--begin::Head-->
   <head>
      <title>@yield('title')</title>
      <meta charset="utf-8"/>
      <link rel="canonical" href="https://preview.keenthemes.com/keen/demo1/apps/ecommerce/catalog/add-category.html"/>
      <link rel="shortcut icon" href="/keen/demo1/assets/media/logos/favicon.ico"/>
      <!--begin::Fonts(mandatory for all pages)-->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
      <!--end::Fonts-->
      <!--begin::Vendor Stylesheets(used for this page only)-->
      <link href="/keen/demo1/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
      <!--end::Vendor Stylesheets-->
      <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
      <link href="{{ asset('css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
      <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!--end::Global Stylesheets Bundle-->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <script>
         // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
         if (window.top != window.self) {
             window.top.location.replace(window.self.location.href);
         }
      </script>
   </head>
   <!--end::Head-->
   <!--begin::Body-->
   <body  id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"  class="app-default" >
      <!--begin::Theme mode setup on page load-->
      <script>
         var defaultThemeMode = "light";
         var themeMode;
         
         if ( document.documentElement ) {
         	if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
         		themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
         	} else {
         		if ( localStorage.getItem("data-bs-theme") !== null ) {
         			themeMode = localStorage.getItem("data-bs-theme");
         		} else {
         			themeMode = defaultThemeMode;
         		}			
         	}
         
         	if (themeMode === "system") {
         		themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
         	}
         
         	document.documentElement.setAttribute("data-bs-theme", themeMode);
         }            
      </script>
      <!--end::Theme mode setup on page load-->
      <!--begin::App-->
      <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
         <!--begin::Page-->
         <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
            <!--begin::Header-->
            @include('menu/header')
            <!--end::Header-->        
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
               <!--begin::Sidebar-->
               @include('menu/leftmenu')
               <!--end::Sidebar-->                
               <!--begin::Main-->
               <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                  <!--begin::Content wrapper-->
                  @yield('content')
                  <!--end::Content wrapper-->
                  <!--begin::Footer-->
                  @include('menu/footer')
                  <!--end::Footer-->                            
               </div>
               <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
         </div>
         <!--end::Page-->
      </div>
      <!--end::App-->
      <script src="{{ asset('js/plugins.bundle.js') }}"></script>
      <script src="{{ asset('js/scripts.bundle.js') }}"></script>
   </body>
   <!--end::Body-->
</html>
y