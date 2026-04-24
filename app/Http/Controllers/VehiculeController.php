<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicule\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    public function index() {}
    public function create() {}
    public function store(StoreRequest $request)
    {
        $chauffeur = Auth::user()->role->type;
        if ($chauffeur == 'chauffeur') {
            $chauffeur->vehicules()->create([
                'type_vehicule'      => $request->type_vehicule,
                'immatriculation'    => $request->immatriculation,
                'capacite_charge_kg' => $request->capacite_charge_kg,
                'capacite_volume_m3' => $request->capacite_volume_m3,
            ]);
            return redirect(route(''));
        }
        return redirect(route(''));
        
    }
}
