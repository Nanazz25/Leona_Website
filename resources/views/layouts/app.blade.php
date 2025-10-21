<!DOCTYPE html>
<html lang="en">
<!-- head -->
<x-head>
    <x-slot:title>
        @yield('title')
        </x-slot:titlex>
        <x-slot:head>
            @yield('head')
        </x-slot:head>
</x-head>
<!-- end head -->

<body>
    <script src="{{ asset('assets/js/preloader.js') }}"></script>
    <div class="body-wrapper">
        <!-- sidebar -->
        <x-sidebar />
        <!-- end sidebar -->
        <div class="main-wrapper mdc-drawer-app-content">

            <!-- navbar -->
            <x-navbar>
                <x-slot:namaPage>
                    @yield('namaPage')
                </x-slot:namaPage>
            </x-navbar>
            <!-- end navbar -->

            <div class="page-wrapper mdc-toolbar-fixed-adjust">
                <main class="content-wrapper">

                    @yield('content')

                </main>

                <!-- footer -->
                <x-footer />
                <!-- end footer -->
            </div>
        </div>
    </div>

    <!-- Script -->
    <x-script>
        <x-slot:afterAppScripts>
            @yield('afterAppScripts')
        </x-slot:afterAppScripts>
    </x-script>
    <!-- end script -->

</body>

</html>