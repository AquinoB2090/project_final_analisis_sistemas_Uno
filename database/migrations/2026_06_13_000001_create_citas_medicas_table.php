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
        Schema::create('citas_medicas', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->dateTime('fecha');
            $table->string('paciente');
            $table->string('responsable');
            $table->string('estado')->default('pendiente');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->index(['tenant_id', 'fecha']);
            $table->index(['tenant_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas_medicas');
    }
};
