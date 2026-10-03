<?php

namespace Modules\User\app\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeedPermissions extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'seeder:permissions';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';

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
    public function handle() {

        // | Acción                     | Permission            |
        // | -------------------------- | --------------------- |
        // | Crear ticket               | `create-ticket`       |
        // | Visualizar tickets         | `view-tickets`        |
        // | Asignar tickets            | `assign-tickets`      |
        // | Reasignar tickets          | `reassign-tickets`    |
        // | Mover ticket a "En espera" | `move-ticket-to-wait` |
        // | Agregar observaciones      | `add-observations`    |
        // | Solucionar ticket          | `solve-ticket`        |
        // | Cerrar ticket              | `close-ticket`        |
        // | Cancelar ticket            | `cancel-ticket`       |
        // | Visualizar estadísticas    | `view-statistics`     |
        // | Crear nuevo equipo         | `create-team`         |

        $permissions = [
            [
                'name' => 'manage-user-roles',
                'guard_name' => 'web'
            ],
            [
                'name' => 'create-ticket',
                'guard_name' => 'web'
            ],
            [
                'name' => 'view-tickets',
                'guard_name' => 'web'
            ],
            [
                'name' => 'assign-tickets',
                'guard_name' => 'web'
            ],
            [
                'name' => 'reassign-tickets',
                'guard_name' => 'web'
            ],
            [
                'name' => 'move-ticket-to-wait',
                'guard_name' => 'web'
            ],
            [
                'name' => 'add-observations',
                'guard_name' => 'web'
            ],
            [
                'name' => 'solve-ticket',
                'guard_name' => 'web'
            ],
            [
                'name' => 'close-ticket',
                'guard_name' => 'web'
            ],
            [
                'name' => 'cancel-ticket',
                'guard_name' => 'web'
            ],
            [
                'name' => 'view-statistics',
                'guard_name' => 'web'
            ],
            [
                'name' => 'create-team',
                'guard_name' => 'web'
            ],
        ];

        $ctxPermissions = DB::table('permissions')
            ->pluck('name')
            ->toArray();

        $records = array_filter($permissions, function ($permission) use ($ctxPermissions) {
            return !in_array($permission['name'], $ctxPermissions);
        });

        $records = array_values($records);

        if (is_array($records) && empty($records)) {
            $this->info('No hay permisos nuevos por añadir :(');

        } else {

            //Asignar timestamps
            foreach ($records as &$row) {
                $row['created_at'] = now();
                $row['updated_at'] = now();
            }

            unset($row);

            DB::table('permissions')->insert($records);

            $this->info('Se han creado con éxito ('.  count($records)   .') permisos base del helpdesk :)');
        }
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
