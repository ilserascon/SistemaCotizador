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
        Schema::create('producto_insumo', function (Blueprint $table) {
            $table->foreignId('id_producto')->constrained('producto');
            $table->foreignId('id_insumo')->constrained('insumo');
            $table->decimal('cantidad', 10, 2)->nullable();
            $table->primary(['id_producto', 'id_insumo']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_insumo');
    }
};