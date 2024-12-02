<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToBancos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bancos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->unique(); // Adicionando o campo user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Definindo a relação com a tabela users
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bancos', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Remover a chave estrangeira
            $table->dropColumn('user_id'); // Remover o campo user_id
        });
    }
}
