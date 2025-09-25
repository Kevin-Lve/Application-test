<style>
        .avatar {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border-radius: 50%;
        }
</style>
<div id="kt_app_header" class="app-header">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <!--begin::sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
        <!--end::sidebar mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="/keen/demo1/index.html" class="d-lg-none">
                <img alt="Logo" src="https://companieslogo.com/img/orig/FRVIA.PA-c7851abe.png?t=1720244491" class="theme-light-show h-30px" />
                <img alt="Logo" src="/keen/demo1/assets/media/logos/default-small-dark.svg" class="theme-dark-show h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div
                class="app-header-menu app-header-mobile-drawer align-items-stretch"
                data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu"
                data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true"
                data-kt-drawer-width="225px"
                data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle"
                data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}"
            ></div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::User menu-->
                <div class="app-navbar-item ms-2 ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <div class="avatar text-uppercase">{{ auth()->user()->prenom[0] }} {{ auth()->user()->nom[0] }}</div>
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">

                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <div class="avatar text-uppercase">{{ auth()->user()->prenom[0] }} {{ auth()->user()->nom[0] }}</div>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"> {{ auth()->user()->email }} </a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <a href="/keen/demo1/account/overview.html" class="menu-link px-5">
                                My Profile
                            </a>
                        </div>
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('logout')}}" class="menu-link px-5">
                                Déconnexion
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
                        <i class="ki-duotone ki-element-4 fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
