<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="WasselM3ak - Plateforme de transport et livraison">
    <meta name="theme-color" content="#027cb1">
    
    <title>@yield('title', 'Tableau de bord') | WasselM3ak</title>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://unpkg.com">

    <!-- Fonts (Lato comme dans app.blade.php) -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

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
                            500: '#027cb1',
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
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideIn: { '0%': { transform: 'translateX(-100%)' }, '100%': { transform: 'translateX(0)' } },
                    },
                    boxShadow: {
                        'soft': '0 30px 80px rgba(15, 23, 42, 0.08)',
                        'primary': '0 24px 60px rgba(2, 124, 177, 0.12)',
                        'primary-lg': '0 32px 80px rgba(2, 124, 177, 0.15)',
                        'card': '0 2px 4px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1)',
                        'card-hover': '0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05)',
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
        
        /* Classes réutilisables comme dans app.blade.php */
        .btn-primary { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 9999px; 
            background-color: #027cb1; 
            color: white; 
            padding: 0.75rem 1.5rem; 
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
            padding: 0.75rem 1.5rem; 
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
        
        /* Scrollbar personnalisée (gardée) */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Smooth scrolling */
        html { scroll-behavior: smooth; }
        
        /* Focus visible avec la couleur primaire de la marque */
        :focus-visible { outline: 2px solid #027cb1; outline-offset: 2px; }
        
        /* Désactiver hover sur mobile */
        @media (max-width: 768px) {
            .hover\:scale-105:hover { transform: none; }
            .btn-primary, .btn-secondary { padding: 0.75rem 1.25rem; }
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased text-slate-800 bg-slate-50 h-screen overflow-hidden"
      x-data="{ 
          sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || true,
          theme: localStorage.getItem('theme') || 'light'
      }"
      x-init="() => {
          localStorage.setItem('sidebarOpen', sidebarOpen);
          $watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value));
      }"
      :class="{ 'dark': theme === 'dark' }">

    <div class="h-screen flex overflow-hidden">
        
        <!-- Sidebar avec transition -->
        <div x-cloak
             x-show="sidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-40 w-72 lg:relative lg:translate-x-0"
             :class="{ 'lg:block': sidebarOpen }">
            @yield('sidebar')
        </div>

        <!-- Overlay mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-30 lg:hidden"
             x-cloak></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Header -->
            @include('partials.dashboard-header')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-slate-50/50">
                <div class="container mx-auto px-4 sm:px-6 py-6">
                    
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div x-data="{ show: true }" 
                             x-show="show" 
                             x-init="setTimeout(() => show = false, 5000)"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4">
                            <div class="flex items-center gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
                                <p class="font-medium">{{ session('success') }}</p>
                                <button @click="show = false" class="ml-auto text-emerald-600 hover:text-emerald-800">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div x-data="{ show: true }" 
                             x-show="show" 
                             x-init="setTimeout(() => show = false, 5000)"
                             class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4">
                            <div class="flex items-center gap-3">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                                <p class="font-medium">{{ session('error') }}</p>
                                <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 text-sm text-slate-500">
                    <p>&copy; {{ date('Y') }} WasselM3ak. Tous droits réservés.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-primary-500 transition-colors">Conditions d'utilisation</a>
                        <a href="#" class="hover:text-primary-500 transition-colors">Confidentialité</a>
                        <a href="#" class="hover:text-primary-500 transition-colors">Support</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Axios config
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        axios.defaults.withCredentials = true;
        
        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response && error.response.status === 419) {
                    alert('Votre session a expiré. Veuillez rafraîchir la page.');
                    window.location.reload();
                }
                return Promise.reject(error);
            }
        );
        
        // Lucide icons
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
        
        // Online/offline
        window.addEventListener('online', () => location.reload());
        window.addEventListener('offline', () => alert('Connexion internet perdue.'));
        
        // Prevent double submit
        document.addEventListener('submit', function(e) {
            const button = e.target.querySelector('button[type="submit"]');
            if (button?.dataset.submitted) {
                e.preventDefault();
                return false;
            }
            if (button) {
                button.dataset.submitted = 'true';
                setTimeout(() => delete button.dataset.submitted, 3000);
            }
        });
    </script>

    @stack('scripts')
</body>
</html>