<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Adiciona a coluna para chave estrangeira
            $table->unsignedBigInteger('bancoId')->nullable();
            
            // Demais colunas
            $table->float('incomeToday')->default(0);
            $table->float('incomeDaily')->default(0);
            $table->float('incomeTotal')->default(0);
            $table->float('money')->default(0);
            $table->boolean('isActive')->default(false);

            // Configura a chave estrangeira
            $table->foreign('bancoId')->references('id')->on('bancos')->onDelete('set null');
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
            // Remove a chave estrangeira e a coluna associada
            $table->dropForeign(['bancoId']);
            $table->dropColumn('bancoId');

            // Remove as outras colunas
            $table->dropColumn('incomeToday');
            $table->dropColumn('incomeDaily');
            $table->dropColumn('incomeTotal');
            $table->dropColumn('money');
            $table->dropColumn('isActive');
        });
    }
}
