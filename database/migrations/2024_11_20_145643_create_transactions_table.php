<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('action', ['depositar', 'retirar']);
            $table->float('money');
            $table->enum('status', ['pendente', 'processando', 'concluido'])->default('pendente');
            $table->unsignedBigInteger('bancoId')->nullable();
            $table->timestamps();

            $table->foreign('bancoId')->references('id')->on('bancos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
