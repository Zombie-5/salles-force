<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ResetIncomeToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'incomeToday:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseta o campo incomeToday de todos os usuários para zero';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Reseta o campo incomeToday de todos os usuários
        User::query()->update(['incomeToday' => 0]);

        $this->info('O campo incomeToday foi resetado com sucesso para todos os usuários.');
        return 0;
    }
}
