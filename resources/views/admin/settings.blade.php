@extends('layouts.dashboard')

@section('title', 'Paramètres')

@section('sidebar')
@include('admin.partials.sidebar', ['active' => 'settings'])
@endsection

@section('page-title', 'Paramètres de la plateforme')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-semibold text-slate-900">Paramètres de la plateforme</h3>
        </div>
        <div class="p-6 space-y-6">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')

                <!-- General Settings -->
                <div class="space-y-4">
                    <h4 class="font-medium text-slate-900">Général</h4>
                    
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div>
                            <p class="font-medium text-slate-900">Mode maintenance</p>
                            <p class="text-sm text-slate-500">Mettre la plateforme en maintenance</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="maintenance_mode" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div>
                            <p class="font-medium text-slate-900">Inscriptions</p>
                            <p class="text-sm text-slate-500">Autoriser les nouvelles inscriptions</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="allow_registration" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>
                </div>

                <hr class="border-slate-200">

                <!-- Notifications -->
                <div class="space-y-4">
                    <h4 class="font-medium text-slate-900">Notifications</h4>
                    
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div>
                            <p class="font-medium text-slate-900">Emails automatiques</p>
                            <p class="text-sm text-slate-500">Envoyer des notifications par email</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_notifications" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <div>
                            <p class="font-medium text-slate-900">SMS</p>
                            <p class="text-sm text-slate-500">Envoyer des notifications par SMS</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="sms_notifications" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="reset" class="flex-1 py-3 border border-slate-200 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-lg font-medium transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
