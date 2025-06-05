<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('centros_custo', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20);
            $table->string('nome', 255);
            $table->decimal('orcamento', 15, 2)->nullable();
            $table->string('responsavel', 255)->nullable();
            $table->tinyInteger('ativo')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('centros_custo');
    }
};
