<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WasselM3ak - Transport de marchandises')</title>
    <meta name="description" content="WasselM3ak met en relation expéditeurs et transporteurs pour des livraisons rapides, sécurisées et économiques partout au Maroc.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#0A66C2',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        success: '#10B981',
                        warning: '#F59E0B',
                        error: '#EF4444',
                        gray: {
                            50: '#F9FAFB',
                            100: '#F3F4F6',
                            200: '#E5E7EB',
                            300: '#D1D5DB',
                            400: '#9CA3AF',
                            500: '#6B7280',
                            600: '#4B5563',
                            700: '#374151',
                            800: '#1F2937',
                            900: '#111827',
                        }
                    },
                    },
                    boxShadow: {
                        'classic': 'inset 1px 1px 0px rgba(255,255,255,0.8), inset -1px -1px 0px rgba(0,0,0,0.1), 2px 2px 4px rgba(0,0,0,0.1)',
                        'classic-inset': 'inset 2px 2px 4px rgba(0,0,0,0.1), inset -2px -2px 4px rgba(255,255,255,0.8)',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-800 bg-white">

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>
</html></content>
<parameter name="filePath">c:\Users\Youcode\Desktop\PFR_WasselM3ak\resources\views\layouts\auth.blade.php