@extends('layouts.dashboard')

@section('title', 'Mes courses')

@section('sidebar')
@include('driver.partials.sidebar', ['active' => 'trips'])
@endsection

@section('page-title', 'Mes courses')

@section('content')
<div class="space-y-6">
    <!-- Tabs -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="border-b border-slate-200">
            <nav class="flex -mb-px">
                <a href="#" class="px-6 py-4 border-b-2 border-primary-500 text-primary-600 font-medium">En cours</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">En attente</a>
                <a href="#" class="px-6 py-4 border-b-2 border-transparent text-slate-500 hover:text-slate-700 font-medium">Terminées</a>
            </nav>
        </div>

        <div class="p-6">
            <div class="space-y-4">
                @foreach([
                    ['from' => 'Casablanca', 'to' => 'Rabat', 'client' => 'Ahmed Benali', 'date' => '2024-03-15', 'price' => '350 DH', 'status' => 'en_cours'],
                    ['from' => 'Marrakech', 'to' => 'Agadir', 'client' => 'Sofia El Amrani', 'date' => '2024-03-16', 'price' => '450 DH', 'status' => 'en_attente'],
                    ['from' => 'Tanger', 'to' => 'Tétouan', 'client' => 'Karim Idrissi', 'date' => '2024-03-10', 'price' => '200 DH', 'status' => 'terminee'],
                ] as $trip)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 {{ $trip['status'] === 'terminee' ? 'bg-green-100' : ($trip['status'] === 'en_cours' ? 'bg-blue-100' : 'bg-primary-100') }} rounded-xl flex items-center justify-center">
                            <i data-lucide="{{ $trip['status'] === 'terminee' ? 'check-circle' : ($trip['status'] === 'en_cours' ? 'truck' : 'clock') }}" class="w-6 h-6 {{ $trip['status'] === 'terminee' ? 'text-green-500' : ($trip['status'] === 'en_cours' ? 'text-blue-500' : 'text-primary-500') }}"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">{{ $trip['from'] }} → {{ $trip['to'] }}</p>
                            <p class="text-sm text-slate-500">{{ $trip['client'] }} • {{ $trip['date'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="font-medium text-primary-500">{{ $trip['price'] }}</p>
                        @if($trip['status'] === 'terminee')
                            <span class="px-3 py-1 bg-green-500 text-white text-sm rounded-full">Terminée</span>
                        @elseif($trip['status'] === 'en_cours')
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
