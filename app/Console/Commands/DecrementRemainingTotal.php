<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class DecrementRemainingTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remainingTotal:decrement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrementar o tempo de renda de todas as maquinas do usuario';

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
        $userId = Auth::user();
        $user = User::find($userId->id);
        $user->incomeToday = 0;
        $user->save();

        // Recuperar todas as máquinas do usuário com os dados da pivot
        $machines = $user->machines()->withPivot('remainingTotal')->get();

        // Iterar pelas máquinas para decrementar remainingTotal
        foreach ($machines as $machine) {

            // Decrementar o campo remainingTotal na pivot
            $newRemainingTotal = $machine->pivot->remainingTotal - 1;

            if ($newRemainingTotal > 0) {
                // Atualizar remainingTotal se ainda houver tempo restante
                $user->machines()->updateExistingPivot($machine->id, [
                    'remainingTotal' => $newRemainingTotal,
                ]);

            } else {
                // Remover a relação se remainingTotal chegar a 0
                $user->machines()->detach($machine->id);
                $user->incomeDaily -= $machine->income;
                $user->save();
            }
        }

        return 0;
    }
}
