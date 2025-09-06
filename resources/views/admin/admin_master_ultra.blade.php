<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>🏔️ CERFAOS - Ultra-Modern Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cerfaos - Dashboard d'administration ultra-moderne pour passionnés d'aventure et de montagne">
    <meta name="author" content="Cerfaos Team">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Performance Optimization -->
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://unpkg.com">
    <link rel="dns-prefetch" href="//images.unsplash.com">
    
    <!-- Security -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https: blob:; connect-src 'self';">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1F2937">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('backend/assets/images/apple-touch-icon.png') }}">
    
    <!-- Admin Reset CSS -->
    <link href="{{ asset('css/admin-reset.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- CERFAOS Unified Design System -->
    <link href="{{ asset('css/cerfaos-admin-unified.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Additional CSS for specific pages -->
    @yield('css')
</head>

<body class="admin">
    <!-- Ultra-Modern Layout -->
    <div class="layout">
        
        <!-- Header -->
        @include('admin.body.header-outdoor')
        
        <!-- Sidebar -->
        @include('admin.body.sidebar-outdoor')
        
        <!-- Main Content Area -->
        <main class="layout__main">
            <div class="main__container">
                @yield('admin')
            </div>
        </main>
        
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay"></div>

    <!-- Essential JavaScript -->
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
    
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

    <!-- Additional JavaScript -->
    @yield('js')

</body>
</html>