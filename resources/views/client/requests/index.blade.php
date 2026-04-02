@extends('layouts.dashboard')

@section('title', 'Mes demandes')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'requests'])
@endsection

@section('page-title', 'Mes demandes de transport')

@section('content')
<div class="space-y-6">
    <!-- Tabs -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="border-b border-slate-200">
            <nav class="flex -mb-px">
                <a href="#" class="px-6 py-4 border-b-2 border-primary-500 text-primary-600 font-medium">Toutes</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">En attente</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">En cours</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">Terminées</a>
            </nav>
        </div>

        <div class="p-6">
            <div class="space-y-4">
                @foreach([
                    ['id' => 1, 'from' => 'Casablanca', 'to' => 'Rabat', 'type' => 'Meubles', 'date' => '2024-03-15', 'price' => '350 DH', 'status' => 'en_cours'],
                    ['id' => 2, 'from' => 'Marrakech', 'to' => 'Agadir', 'type' => 'Électroménager', 'date' => '2024-03-10', 'price' => '450 DH', 'status' => 'terminee'],
                    ['id' => 3, 'from' => 'Tanger', 'to' => 'Tétouan', 'type' => 'Cartons', 'date' => '2024-03-18', 'price' => '200 DH', 'status' => 'en_attente'],
                ] as $request)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6 text-primary-500"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">{{ $request['from'] }} → {{ $request['to'] }}</p>
                            <p class="text-sm text-slate-500">{{ $request['type'] }} • {{ $request['date'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="font-medium text-primary-500">{{ $request['price'] }}</p>
                        @if($request['status'] === 'terminee')
                            <span class="px-3 py-1 bg-green-500 text-white text-sm rounded-full">Terminée</span>
                        @elseif($request['status'] === 'en_cours')
                            <span class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full">En cours</span>
                        @else
                            <span class="px-3 py-1 border border-primary-500 text-primary-500 text-sm rounded-full">En attente</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
