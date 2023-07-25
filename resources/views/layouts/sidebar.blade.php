<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('home') }}">
            <img alt="Logo" src="http://radavisdispatch.com/rad-logo-2.png"
                class="h-30px app-sidebar-logo-default" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-sm h-30px w-30px rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-double-left fs-2 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="hover-scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <!--Dashboard-->
                    <div class="menu-item">
                        <a class="menu-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-category fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>

                    <!--Admin Menus-->
                    @hasrole('Admin')

                        <!--Dispatch-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('dispatch*') ? 'active' : '' }}"
                                href="{{ route('dispatch.searchview') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dispatch</span>
                            </a>
                        </div>

                        <!--Commodities-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('commoditie*') ? 'active' : '' }}"
                                href="{{ route('commoditie.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Commodities</span>
                            </a>
                        </div>

                        <!--Suppliers-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('supplier*') ? 'active' : '' }}"
                                href="{{ route('supplier.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Suppliers</span>
                            </a>
                        </div>

                        <!--Exit-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('exit*') ? 'active' : '' }}"
                                href="{{ route('exit.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Exit</span>
                            </a>
                        </div>

                        <!--Trucks-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('via*') ? 'active' : '' }}"
                                href="{{ route('via.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Trucks</span>
                            </a>
                        </div>

                        <!--Truck Directory-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('truck*') ? 'active' : '' }}"
                                href="{{ route('truck.directory') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Truck Directory</span>
                            </a>
                        </div>

                        <!--Destination-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('destination*') ? 'active' : '' }}"
                                href="{{ route('destination.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Destination</span>
                            </a>
                        </div>

                        <!--Rates-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('rate*') ? 'active' : '' }}"
                                href="{{ route('rate.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Rates</span>
                            </a>
                        </div>

                        <!--Config-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('config*') ? 'active' : '' }}"
                                href="{{ route('config.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Config</span>
                            </a>
                        </div>

                        <!--Bulletins-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('bulletins*') ? 'active' : '' }}"
                                href="{{ route('bulletins.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Bulletins</span>
                            </a>
                        </div>

                        <!--Logistics-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('logistics*') ? 'active' : '' }}"
                                href="{{ route('logistics.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Logistics</span>
                            </a>
                        </div>

                        <!--User Management-->
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ request()->is('users*') ? 'show' : '' }}">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-address-book fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                                <span class="menu-title">User Management</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->

                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <!--List-->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->is('users') ? 'active' : '' }}"
                                        href="{{ route('users.index') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">List</span>
                                    </a>
                                </div>
                                <!--Add New-->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->is('users/create') ? 'active' : '' }}"
                                        href="{{ route('users.create') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Add New</span>
                                    </a>
                                </div>
                                <!--Import Data-->
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->is('users/import-users') ? 'active' : '' }}"
                                        href="{{ route('users.import') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Import Data</span>
                                    </a>
                                </div>

                            </div>
                            <!--end:Menu sub-->
                        </div>
                    @endrole

                    <!--Salesman Menus-->
                    @hasrole('salesman')

                        <!--Dispatch-->
                        {{-- <div class="menu-item">
                            <a class="menu-link {{ request()->is('dispatch*') ? 'active' : '' }}"
                                href="{{ route('dispatch.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dispatch</span>
                            </a>
                        </div> --}}

                        <!--Search Dispatch-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('dispatch/searchview') ? 'active' : '' }}"
                                href="{{ route('dispatch.searchview') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                {{-- <span class="menu-title">Search Dispatch</span> --}}
                                <span class="menu-title">Dispatch</span>
                            </a>
                        </div>

                        <!--Truck Directory-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('truck*') ? 'active' : '' }}"
                                href="{{ route('truck.directory') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Truck Directory</span>
                            </a>
                        </div>
                    @endrole

                    <!--Truck Menus-->
                    @hasrole('truck')

                        <!--Dispatch-->
                        {{-- <div class="menu-item">
                            <a class="menu-link {{ request()->is('dispatch') ? 'active' : '' }}"
                                href="{{ route('dispatch.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dispatch</span>
                            </a>
                        </div> --}}

                        <!--Search Dispatch-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('dispatch/searchview') ? 'active' : '' }}"
                                href="{{ route('dispatch.searchview') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dispatch</span>
                            </a>
                        </div>

                        <!--Logistics-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->is('logistics*') ? 'active' : '' }}"
                                href="{{ route('logistics.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-category fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Logistics</span>
                            </a>
                        </div>
                    @endrole

                    <!--Sign Out-->
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-category fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="menu-title">Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>

                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->

</div>
