@php
    function isActive($routes) {
        return request()->routeIs($routes) ? 'mdc-list-item--activated' : '';
    }
@endphp

<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
    <div class="mdc-drawer__header">
        <a href="index.html" class="brand-logo">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
        </a>
    </div>
    <div class="mdc-drawer__content">
        {{-- <div class="user-info">
            <p class="name">Leona</p>
            <p class="email">leona@leona.com</p>
        </div> --}}
        <div class="mdc-list-group">
            <nav class="mdc-list mdc-drawer-menu">
                <div class="mdc-list-item mdc-drawer-item {{ isActive('dashboard.index') }}">
                    <a class="mdc-drawer-link" href="{{ route('dashboard.index') }}">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">home</i>
                        Dashboard
                    </a>
                </div>
                
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel"
                        data-target="sample-page-submenu">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">pages</i>
                        Sample Pages
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel" id="sample-page-submenu">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="pages/samples/blank-page.html">
                                    Blank Page
                                </a>
                            </div>
                            
                        </nav>
                    </div>
                </div>
                
            </nav>
        </div>
    </div>
</aside>
