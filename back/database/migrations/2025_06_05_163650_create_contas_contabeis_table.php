<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('contas_contabeis', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20);
            $table->string('descricao', 255);
            $table->string('tipo', 7);
            $table->integer('nivel')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contas_contabeis');
    }
};
