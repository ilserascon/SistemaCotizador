<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->boolean('activo')->default(0); // 1 para activo por defecto
        });
    }
    
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }
    
};
