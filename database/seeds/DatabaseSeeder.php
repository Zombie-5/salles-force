<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* // Verifica qual banco de dados está sendo utilizado
        if (DB::getDriverName() == 'mysql') {
            // Comando para MySQL
            DB::statement("ALTER TABLE users AUTO_INCREMENT = 5100");
        } elseif (DB::getDriverName() == 'pgsql') {
            // Comando para PostgreSQL
            DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 5100");
        } */

        //$this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
    }
}
