<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lancamentos_contabeis', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('descricao', 255)->nullable();
            $table->decimal('valor', 15, 2);
            $table->string('tipo', 7);
            $table->bigInteger('centro_custo_id')->nullable();
            $table->bigInteger('conta_contabil_id')->nullable();
            $table->bigInteger('documento_id')->nullable();
            $table->tinyInteger('conciliado')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lancamentos_contabeis');
    }
};
