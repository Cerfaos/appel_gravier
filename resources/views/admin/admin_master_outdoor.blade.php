<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="utf-8" />
        <title>🏔️ CERFAOS - Outdoor Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Cerfaos - Dashboard d'administration outdoor pour passionnés d'aventure et de montagne"/>
        <meta name="author" content="Cerfaos Team"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico')}}">

        <!-- Admin Reset CSS -->
        <link href="{{ asset('css/admin-reset.css') }}" rel="stylesheet" type="text/css" />
        
        <!-- CERFAOS Unified Design System -->
        <link href="{{ asset('css/cerfaos-admin-unified.css') }}" rel="stylesheet" type="text/css" />

        <!-- CERFAOS Ultra-Modern Layout Fix -->
        <style>
            /* Reset et fix pour système ultra-moderne */
            body {
                margin: 0 !important;
                padding: 0 !important;
                overflow-x: hidden !important;
            }
        </style>

    </head>

    <!-- Body avec design élégant et professionnel -->
    <body class="admin">

        <!-- CERFAOS Elegant Admin Layout -->
        <div class="layout">
            
            <!-- Header élégant -->
            @include('admin.body.header-outdoor')
            
            <!-- Sidebar élégante -->
            @include('admin.body.sidebar-outdoor')
            
            <!-- Main Content Area -->
            <main class="layout__main">
                <div>
                    @yield('admin')
                </div>
            </main>
            
        </div>

        <!-- Essential JS -->
        <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js')}}"></script>
        
        <!-- CERFAOS Unified Admin JavaScript -->
        <script src="{{ asset('js/cerfaos-admin-unified.js')}}"></script>

        <!-- Messages avec système unifié -->
        <script>
         @if(Session::has('message'))
         document.addEventListener('DOMContentLoaded', function() {
             var type = "{{ Session::get('alert-type','info') }}";
             var message = "{{ Session::get('message') }}";
             
             // Use unified notification system
             if (typeof showNotification === 'function') {
                 showNotification(message, type);
             }
         });
         @endif 
        </script>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    </body>
</html>