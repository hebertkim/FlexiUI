<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('documentos_fiscais', function (Blueprint $table) {
            $table->bigInteger('id')->primary()->autoIncrement();
            $table->string('numero', 50)->nullable();
            $table->string('serie', 10)->nullable();
            $table->date('data_emissao')->nullable();
            $table->decimal('valor_total', 15, 2)->nullable();
            $table->string('cfop', 10)->nullable();
            $table->string('ncm', 20)->nullable();
            $table->string('cst', 10)->nullable();
            $table->string('chave_acesso', 60)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos_fiscais');
    }
};
