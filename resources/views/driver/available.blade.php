@extends('layouts.dashboard')

@section('title', 'Demandes disponibles')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'available'])
@endsection

@section('page-title', 'Demandes disponibles')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="flex items-center justify-between">
        <div class="relative w-96">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
            <input type="text" placeholder="Rechercher par ville..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">Filtrer</button>
            <button class="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">Trier</button>
        </div>
    </div>

    <!-- Requests List -->
    <div class="space-y-4">
        @foreach([
            ['from' => 'Casablanca', 'to' => 'Rabat', 'date' => '2024-03-15', 'price' => '350 DH', 'type' => 'Meubles', 'weight' => '150 kg'],
            ['from' => 'Marrakech', 'to' => 'Agadir', 'date' => '2024-03-16', 'price' => '450 DH', 'type' => 'Électroménager', 'weight' => '80 kg'],
            ['from' => 'Tanger', 'to' => 'Tétouan', 'date' => '2024-03-17', 'price' => '200 DH', 'type' => 'Cartons', 'weight' => '50 kg'],
            ['from' => 'Fès', 'to' => 'Meknès', 'date' => '2024-03-18', 'price' => '280 DH', 'type' => 'Meubles', 'weight' => '120 kg'],
        ] as $request)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="package" class="w-8 h-8 text-primary-500"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="map-pin" class="w-4 h-4 text-slate-400"></i>
                            <span class="font-medium text-slate-900">{{ $request['from'] }}</span>
                            <i data-lucide="navigation" class="w-4 h-4 text-primary-500"></i>
                            <span class="font-medium text-slate-900">{{ $request['to'] }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-slate-500">
                            <span>{{ $request['type'] }}</span>
                            <span>•</span>
                            <span>{{ $request['weight'] }}</span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                {{ $request['date'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-2xl font-bold text-primary-500">{{ $request['price'] }}</p>
                        <p class="text-sm text-slate-500">Prix proposé</p>
                    </div>
                    {{-- {{ route('driver.accept', 1) }} --}}
                    <form method="POST" action="">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-medium transition-colors">
                            Accepter
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
