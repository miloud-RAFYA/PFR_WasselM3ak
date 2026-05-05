<header class="bg-white shadow-sm px-4 sm:px-6 py-4 sticky top-0 z-30">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        
        {{-- LOGO & TITRE --}}
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-2 hover:bg-slate-100 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <i data-lucide="menu" class="w-5 h-5 text-slate-600"></i>
            </button>
            <div class="hidden sm:block">
                <h1 class="text-xl font-semibold text-slate-900">
                    @yield('page-title', 'Tableau de bord')
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ now()->format('l d F Y') }}
                </p>
            </div>
        </div>

        {{-- ACTIONS & USER --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center">
            
            {{-- Availability Toggle (si présent) --}}
            @hasSection('availability-toggle')
                @yield('availability-toggle')
            @endif

            {{-- Barre de recherche --}}
            <div class="relative w-full md:w-64">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" 
                       id="searchInput"
                       placeholder="Rechercher..." 
                       autocomplete="off"
                       class="pl-10 pr-4 py-2 w-full border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
            </div>

            {{-- NOTIFICATIONS --}}
            <div x-data="{ open: false, unreadCount: {{ auth()->user()->unreadNotifications->count() }} }" class="relative">

                <button @click="open = !open; if(open) markAsRead()" 
                        class="relative p-2 hover:bg-slate-100 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <i data-lucide="bell" class="w-5 h-5 text-slate-600"></i>
                    
                    <template x-if="unreadCount > 0">
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full min-w-[18px] text-center animate-pulse">
                            <span x-text="unreadCount > 99 ? '99+' : unreadCount"></span>
                        </span>
                    </template>
                </button>

                <!-- Dropdown Notifications -->
                <div x-show="open" 
                     @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute right-0 mt-2 w-80 bg-white shadow-xl rounded-xl border border-slate-100 overflow-hidden z-50">
                    
                    <div class="flex justify-between items-center p-4 border-b border-slate-100">
                        <h4 class="font-semibold text-slate-900">Notifications</h4>
                        <button @click="markAllAsRead" 
                                class="text-xs text-primary-500 hover:text-primary-600 transition-colors">
                            Tout marquer comme lu
                        </button>
                    </div>
                    
                    <div class="max-h-96 overflow-y-auto divide-y divide-slate-50">
                        @forelse(auth()->user()->notifications->take(5) as $notif)
                            <div class="p-4 hover:bg-slate-50 transition-colors cursor-pointer {{ $notif->read_at ? 'opacity-75' : 'bg-primary-50' }}">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        <i data-lucide="{{ $notif->data['icon'] ?? 'bell' }}" class="w-5 h-5 text-primary-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-slate-700">{{ $notif->data['message'] ?? 'Nouvelle notification' }}</p>
                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if(!$notif->read_at)
                                        <button onclick="markNotificationAsRead('{{ $notif->id }}')" 
                                                class="text-xs text-primary-500 hover:text-primary-600">
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <i data-lucide="inbox" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                                <p class="text-sm text-slate-500">Aucune notification</p>
                            </div>
                        @endforelse
                    </div>
                    
                    @if(auth()->user()->notifications->count() > 0)
                        <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
                            <a href="{{ route('notifications.index') }}" class="text-xs text-primary-500 hover:text-primary-600">
                                Voir toutes les notifications
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- MENU UTILISATEUR --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center gap-3 px-2 py-1.5 hover:bg-slate-100 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-medium shadow-md">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-slate-900">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                        <p class="text-xs text-slate-500">{{ ucfirst(Auth::user()->role->type ?? 'user') }}</p>
                    </div>
                    <i data-lucide="chevron-down" class="hidden md:block w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                    
                    <div class="px-4 py-3 border-b border-slate-100 md:hidden">
                        <p class="text-sm font-medium text-slate-900">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    
                    <a href="{{ route('profile') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-slate-700 hover:bg-slate-50 transition-colors">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span class="text-sm">Mon profil</span>
                    </a>
                    {{-- {{ route('settings') }} --}}
                    <a href="" 
                       class="flex items-center gap-3 px-4 py-2.5 text-slate-700 hover:bg-slate-50 transition-colors">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        <span class="text-sm">Paramètres</span>
                    </a>
                    
                    @if(Auth::user()->role->type === 'driver')
                    <a href="{{ route('driver.vehicle') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-slate-700 hover:bg-slate-50 transition-colors">
                        <i data-lucide="truck" class="w-4 h-4"></i>
                        <span class="text-sm">Mon véhicule</span>
                    </a>
                    @endif
                    
                    <hr class="my-2 border-slate-100">
                    
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="submit" 
                                class="flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors w-full">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span class="text-sm">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
// Fonctions pour les notifications
function markNotificationAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(() => {
        location.reload();
    });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => {
        location.reload();
    });
}

// Recherche en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            const query = this.value;
            if (query.length > 2) {
                // Déclencher la recherche
                window.dispatchEvent(new CustomEvent('search', { detail: query }));
            }
        }, 300));
    }
});

// Debounce helper
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>

<style>
/* Animation pour les dropdowns */
[x-cloak] { display: none !important; }
</style>