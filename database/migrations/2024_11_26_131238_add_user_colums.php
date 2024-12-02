<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserColums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remover a coluna 'convite'
            $table->dropColumn('convite');

            // Adicionar as novas colunas
            $table->unsignedBigInteger('userId')->nullable(); // Referência para o usuário
            $table->boolean('isVip')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Restaurar a coluna 'convite'
            $table->string('convite')->nullable();

            // Remover as novas colunas
            $table->dropColumn('userId');
            $table->dropColumn('isVip');
        });
    }
}
