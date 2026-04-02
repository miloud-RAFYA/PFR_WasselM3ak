<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
             $table->string('reference');
            $table->string('ville_depart');
            $table->string('ville_arrive');
            $table->string('type_marchendise');
            $table->float('poids_kg');
            $table->float('prix_estime');
            $table->float('prix_final');
            $table->enum('status',['pending', 'in_progress', 'delivered']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
