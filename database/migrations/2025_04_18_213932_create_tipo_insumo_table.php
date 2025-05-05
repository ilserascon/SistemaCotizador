<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipo_insumo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('campo1')->nullable();
            $table->string('campo2')->nullable();
            $table->string('campo3')->nullable();
            $table->string('campo4')->nullable();
            $table->string('campo5')->nullable();
            $table->string('campo6')->nullable();
            $table->string('campo7')->nullable();
            $table->string('campo8')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        DB::table('tipo_insumo')->insert([
            'nombre' => 'Telas',
            'campo1' => 'Diseño',
            'campo2' => 'Ancho',
            'campo3' => 'Unidad de Medida',
            'campo4' => 'Composición',
            'campo5' => 'Libro',
            'campo6' => 'Precio CO',
            'campo7' => 'Precio RO',
            'campo8' => 'Precio Volumen',
            'created_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_insumo');
    }
};
