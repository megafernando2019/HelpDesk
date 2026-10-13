<?php

namespace Modules\Tickets\Console;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Tickets\Models\Ticket;
use Modules\Tickets\Services\TicketLogService;
use Modules\Tickets\Support\Enums\TicketAction;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AutoCloseTicketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tickets:auto-close';

    /**
     * The console command description.
     */
    protected $description = 'Cierra automáticamente los tickets solucionados (estatus 4 a 5) tras 3 días hábiles.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(
        TicketLogService $ticketLogService
    ) {

        if (Carbon::now()->isWeekend()) {
            $this->info("Hoy es fin de semana. El comando no procesa cierres hoy por regla de negocio.");
            return Command::SUCCESS;
        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $limitDate = Carbon::now()->subWeekdays(3);

        // Buscar tickets en estatus 4 (Solucionado) cuyo cambio a estatus 4 haya ocurrido hace 3 días hábiles o más
        // Se asume 'updated_at' o el campo donde guardas la fecha de solución
        $ticketsToClose = Ticket::where('status_id', 4)
            ->where('updated_at', '>=', $startOfMonth) 
            ->where('updated_at', '<=', $limitDate)
            ->get();

        $count = 0;

        //Traer al usuario bot 
        $idSSO = 'SYSTEM_BOT_01';
        $userBot = User::where('id_sso', $idSSO)->select('id','id_sso')->first();

        if (!$userBot) {
            $this->info('No se encontró al usuario bot por defecto.');
            return Command::INVALID;
        }

        foreach ($ticketsToClose as $ticket) {
            $ticket->update([
                'status_id' => 5, // Pasar a cerrado
            ]);

            // Registrar en el log de auditoría si usas tu log_service
            $ticketLogService->logAction(
                    $ticket, 
                    TicketAction::STATUS_CLOSED,
                    'update',
                    'tickets/show',
                    null,
                    null,
                    null,
                    null,
                    $userBot->id
            );

            $count++;
        }

        $this->info("Se cerraron automáticamente {$count} tickets.");

        return Command::SUCCESS;
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
