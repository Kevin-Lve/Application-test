<div
    id="kt_app_sidebar"
    class="app-sidebar flex-column"
    data-kt-drawer="true"
    data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
>
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('dashboard.show') }}">
            <img alt="Logo" src="{{ asset('img/logo/long_logo_white.png') }}" class="h-30px app-sidebar-logo-default" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div
            id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-sm h-30px w-30px rotate"
            data-kt-toggle="true"
            data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize"
        >
            <i class="ki-duotone ki-double-left fs-2 rotate-180"><span class="path1"></span><span class="path2"></span></i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::Sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div
                id="kt_app_sidebar_menu_scroll"
                class="hover-scroll-y my-5 mx-3"
                data-kt-scroll="true"
                data-kt-scroll-activate="true"
                data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu"
                data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true"
            >
                <!--begin::Menu-->
                <div
                    class="menu menu-column menu-rounded menu-sub-indention fw-semibold"
                    id="#kt_app_sidebar_menu"
                    data-kt-menu="true"
                    data-kt-menu-expand="false"
                >
                    <!--begin:Menu item-->
                    <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                        <!-- Dashboard -->
                        <x-menu-item-standalone
                            title="Tableau de Bord"
                            route="{{ route('dashboard.show') }}"
                            iconClass="fa-solid fa-chart-line"
                        />

                        <!-- Demande 
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Demande" iconClass="fa-solid fa-cart-flatbed" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Consulter Demande"
                                    route="{{ route('superviseur.demande.gestion') }}"
                                />
                                <x-menu-item-standalone
                                    title="Créer Demande"
                                    route="{{ route('superviseur.demande.creer') }}"
                                />
                            </div>
                        </div>  -->
                        

                        


                        <!-- Separator -->
                        <x-menuSeparator title="Pages IT" />

                        <!-- IT Demande 
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Demande" iconClass="fa-solid fa-cart-flatbed" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Consulter Demande"
                                    route="{{ route('it.demande.gestion') }}"
                                />
                            </div>
                        </div> -->


                        <!-- Service -->
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Service" iconClass="fa-solid fa-users"/>
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Service"
                                    route="{{ route('service.show.index') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Service"
                                    route="{{ route('service.create.show') }}"
                                />
                            </div>
                        </div>

                        <!-- Utilisateur -->
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Utilisateur" iconClass="fa-solid fa-user-tag" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Utilisateur"
                                    route="{{ route('user.show.index') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Utilisateur"
                                    route="{{ route('user.create.show') }}"
                                />
                            </div>
                        </div>
                        

                        <!-- Inventaire -->
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Inventaire" iconClass="fa-solid fa-boxes-stacked" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Equipement"
                                    route="{{ route('equipement.show.index') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Equipement"
                                    route="{{ route('equipement.create.show') }}"
                                />
                                <x-menu-item-standalone
                                    title="Attribuer Equipement"
                                    route=""
                                />
                            </div>
                        </div>

                        <!-- Gestion Catégorie -->
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Catégorie" iconClass="fa-solid fa-layer-group" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Catégorie"
                                    route="{{ route('categorie.show.index') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Catégorie"
                                    route="{{ route('categorie.create.show') }}"
                                />
                            </div>
                        </div>

                        <!-- Fournisseur -->
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Fournisseur" iconClass="fa-solid fa-truck-field" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Fournisseur"
                                    route="{{ route('fournisseur.show.index') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Fournisseur"
                                    route="{{ route('fournisseur.create.show') }}"
                                />
                            </div>
                        </div>

                        <!-- Emplacement -->
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Emplacement" iconClass="fa-solid fa-location-dot" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Emplacement"
                                    route="{{ route('emplacement.show.index') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Emplacement"
                                    route="{{ route('emplacement.create.show') }}"
                                />
                            </div>
                        </div>

                        <!-- Document 
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Document" iconClass="fa-solid fa-folder" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Document"
                                    route="{{ route('it.document.gestion') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Document"
                                    route="{{ route('it.document.ajouter') }}"
                                />
                            </div>
                        </div> -->

                        
                        <!-- Vlan -->
                        <div class="menu-item menu-accordion" data-kt-menu-trigger="click">
                            <x-menuItemLink title="Vlan" iconClass="fa-solid fa-circle-nodes" />
                            <div class="menu-sub menu-sub-accordion">
                                <x-menu-item-standalone
                                    title="Liste Vlan"
                                    route="{{ route('vlan.show.index') }}"
                                />
                                <x-menu-item-standalone
                                    title="Ajouter Vlan"
                                    route="{{ route('vlan.create.show') }}"
                                />
                            </div>
                        </div>


                        

                        <!-- Separator -->
                        <x-menuSeparator title="Pages" />
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::Sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a
            href=""
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
            data-bs-toggle="tooltip"
            data-bs-trigger="hover"
            data-bs-dismiss-="click"
            title="200+ in-house components and 3rd-party plugins"
        >
            <span class="btn-label">
                Docs & Components
            </span>
            <i class="ki-duotone ki-document btn-icon fs-2 m-0"><span class="path1"></span><span class="path2"></span></i>
        </a>
    </div>
    <!--end::Footer-->
</div>
