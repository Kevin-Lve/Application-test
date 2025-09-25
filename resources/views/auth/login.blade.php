<!DOCTYPE html>
<html lang="fr" >
   <head>
      <title>Login</title>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
      <link href="{{ asset('css/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
      <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
   </head>
   <body  id="kt_body"  class="app-blank app-blank" >
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
      <div class="d-flex flex-column flex-root" id="kt_app_root">
         <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover  bgi-position-center" style="background-image: url({{ asset('img/auth/FORVIA_background.jpg') }})"></div>
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
               <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                  <div class="w-lg-500px p-10">
                     <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="/keen/demo1/index.html" action="{{ route('login.make')}}" method="POST">
                        @csrf
                        <div class="text-center mb-11">
                           <h1 class="text-gray-900 fw-bolder mb-3">
                              Se connecter
                           </h1>
                        </div>
                        @error('general')
                            <p>{{ $message }}</p>
                        @enderror
                        <div class="fv-row mb-8">
                           <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent"/>
                        </div>
                        <div class="fv-row mb-3">
                           <input type="password" placeholder="Mot de passe" name="password" autocomplete="off" class="form-control bg-transparent"/>
                        </div>
                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                           <div></div>
                           <a href="/keen/demo1/authentication/layouts/corporate/reset-password.html" class="link-primary">
                           Mot de passe oublié ?
                           </a>
                        </div>
                        <div class="d-grid mb-10">
                           <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">
                                    Se connecter</span>
                                <span class="indicator-progress">
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
