<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIsActiveDefaultOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove a coluna isActive
            $table->dropColumn('isActive');
        });

        // Recria a coluna isActive com o valor default como true
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('isActive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove a coluna isActive
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('isActive');
        });

        // Recria a coluna isActive com o valor default como false
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('isActive')->default(false);
        });
    }
}
