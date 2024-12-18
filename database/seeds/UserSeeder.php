<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* User::create([
            'telefone' => '921621790',
            'password' => Hash::make('123456789')
        ]); */

        $adminUser = User::firstOrCreate(
            ['id' => 1], // Condições para verificar existência
            [ // Dados a serem criados se não existir
                'telefone' => 'admin@mina.vip',
                'password' => Hash::make('fortuna')
            ]
        );

        if ($adminUser->wasRecentlyCreated) {
            // Exibe mensagem se o usuário foi criado agora
            $this->command->info('Usuário admin@mina.vip foi criado com sucesso!');
        } else {
            // Exibe mensagem se o usuário já existia
            $this->command->info('Usuário admin@mina.vip já existe.');
        }
    }
}
