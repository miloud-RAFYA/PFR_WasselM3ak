{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="WasselM3ak - Transport de marchandises au Maroc. Expédiez vos colis et trouvez des transporteurs fiables.">
    <title>@yield('title', 'WasselM3ak - Transport de marchandises')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Lato', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#e6f4f9',
                            100: '#cce9f3',
                            200: '#99d3e7',
                            300: '#66bddb',
                            400: '#33a7cf',
                            500: '#027cb1',    // Couleur principale
                            600: '#02638e',
                            700: '#014a6a',
                            800: '#013247',
                            900: '#001923',
                        },
                        secondary: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#4cca73',
                            600: '#33a65e',
                            700: '#227a47',
                        },
                        slate: {
                            900: '#0f172a',
                        }
                    },
                    boxShadow: {
                        soft: '0 30px 80px rgba(15, 23, 42, 0.08)',
                        'primary': '0 24px 60px rgba(2, 124, 177, 0.12)',
                        'primary-lg': '0 32px 80px rgba(2, 124, 177, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        body { 
            font-family: 'Lato', sans-serif; 
            background-color: #f8fafc; 
            color: #0f172a; 
        }
        
        .btn-primary { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 9999px; 
            background-color: #027cb1; 
            color: white; 
            padding: 0.95rem 1.7rem; 
            font-weight: 600; 
            box-shadow: 0 24px 60px rgba(2, 124, 177, 0.12); 
            transition: all 0.2s ease; 
        }
        
        .btn-primary:hover { 
            background-color: #02638e; 
            transform: translateY(-2px);
            box-shadow: 0 28px 70px rgba(2, 124, 177, 0.2);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-secondary { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 9999px; 
            border: 1px solid #cbd5e1; 
            background-color: white; 
            color: #0f172a; 
            padding: 0.95rem 1.7rem; 
            font-weight: 600; 
            transition: all 0.2s ease; 
        }
        
        .btn-secondary:hover { 
            background-color: #f8fafc; 
            border-color: #027cb1; 
            color: #027cb1; 
        }
        
        .section-card { 
            background-color: white; 
            border: 1px solid rgba(148, 163, 184, 0.16); 
            border-radius: 1.75rem; 
        }
        
        .floating-card { 
            background-color: white; 
            border-radius: 1.5rem; 
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12); 
        }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        /* Safe area insets */
        .safe-top {
            padding-top: env(safe-area-inset-top);
        }
        
        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom);
        }
        
        /* Touch optimization */
        @media (max-width: 768px) {
            .btn-primary, .btn-secondary {
                padding: 0.75rem 1.25rem;
            }
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-800 bg-white" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
    
    {{-- CONDITION : Affiche la navigation uniquement si on n'est PAS sur login ou register --}}
    @if(!Route::is('signup') && !Route::is('showLogin'))
        @include('partials.navigation')
    @endif
    
    <main class="{{ Route::is('login') || Route::is('register') ? '' : 'min-h-screen' }}">
        @yield('content')
    </main>
    
    {{-- CONDITION : Masque aussi le footer sur les pages d'auth --}}
    @if(!Route::is('login') && !Route::is('register'))
        @include('partials.footer')
    @endif
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
    
    @stack('scripts')
</body>
</html>