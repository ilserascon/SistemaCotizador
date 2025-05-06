<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->string('razon_social')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('proveedores', function (Blueprint $table) {
            $table->string('razon_social')->nullable(false)->change();
        });
    }
    
};
