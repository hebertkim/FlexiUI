<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_connections', function (Blueprint $table) {
            $table->id();
            $table->string('nome_conexao');
            $table->string('tipo_banco'); // mysql, pgsql, sqlsrv
            $table->string('host');
            $table->string('porta');
            $table->string('database');
            $table->string('username');
            $table->string('password')->nullable(); // criptografado (idealmente)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_connections');
    }
};
