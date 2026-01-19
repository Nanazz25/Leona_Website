@php
    function isActive($routes)
    {
        return request()->routeIs($routes) ? 'mdc-list-item--activated' : '';
    }

    function isExpanded($routes)
    {
        return request()->routeIs($routes) ? 'expanded' : '';
    }

    function isShow($routes)
    {
        return request()->routeIs($routes) ? 'display: block;' : '';
    }
@endphp

<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
    <div class="mdc-drawer__header">
        <a href="{{ route('dashboard.index') }}" class="brand-logo" style="text-decoration: none;">
            <span style="font-weight: bold; color: white; font-size: 1.5rem;">Leona App</span>
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
                    <a class="mdc-expansion-panel-link {{ isExpanded(['guru.*', 'murid.*']) }}" href="#" data-toggle="expansionPanel"
                        data-target="submenu-identitas">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">pages</i>
                        Identitas
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel {{ isExpanded(['guru.*', 'murid.*']) }}" id="submenu-identitas" style="{{ isShow(['guru.*', 'murid.*']) }}">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item {{ isActive('guru.*') }}">
                                <a class="mdc-drawer-link" href="{{ route('guru.index') }}">Guru</a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item {{ isActive('murid.*') }}">
                                <a class="mdc-drawer-link" href="{{ route('murid.index') }}">Murid</a>
                            </div>
                        </nav>
                    </div>
                </div>

                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link {{ isExpanded(['userguru.*', 'usermurid.*']) }}" href="#" data-toggle="expansionPanel"
                        data-target="submenu-identitas-user">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">pages</i>
                         account
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel {{ isExpanded(['userguru.*', 'usermurid.*']) }}" id="submenu-identitas-user" style="{{ isShow(['userguru.*', 'usermurid.*']) }}">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item {{ isActive('userguru.*') }}">
                                <a class="mdc-drawer-link" href="{{ route('userguru.index') }}">guru dan kurikulum</a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item {{ isActive('usermurid.*') }}">
                                <a class="mdc-drawer-link" href="{{ route('usermurid.index') }}">murid</a>
                            </div>
                        </nav>
                    </div>
                </div>

                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-expansion-panel-link {{ isExpanded(['jurusan.*', 'kelas.*', 'mata_pelajaran.*']) }}" href="#" data-toggle="expansionPanel"
                        data-target="submenu-identitas-kelas">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                            aria-hidden="true">pages</i>
                        Identitas Kelas
                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                    </a>
                    <div class="mdc-expansion-panel {{ isExpanded(['jurusan.*', 'kelas.*', 'mata_pelajaran.*']) }}" id="submenu-identitas-kelas" style="{{ isShow(['jurusan.*', 'kelas.*', 'mata_pelajaran.*']) }}">
                        <nav class="mdc-list mdc-drawer-submenu">
                            <div class="mdc-list-item mdc-drawer-item {{ isActive('jurusan.*') }}">
                                <a class="mdc-drawer-link" href="{{ route('jurusan.index') }}">Jurusan</a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item {{ isActive('kelas.*') }}">
                                <a class="mdc-drawer-link" href="{{ route('kelas.index') }}">Kelas</a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item {{ isActive('mata_pelajaran.*') }}">
                                <a class="mdc-drawer-link" href="{{ route('mata_pelajaran.index') }}">Mata Pelajaran</a>
                            </div>
                        </nav>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</aside>