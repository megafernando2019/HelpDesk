<?php

namespace Modules\Tickets\Console;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Services\Models\TicketServiceEntity;
use Modules\Tickets\Models\Ticket;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeedBulkTicketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tickets:bulk-seed {--rollback : Revierte la inserción masiva usando el archivo JSON de datos}';
    /**
     * The console command description.
     */
    protected $description = 'Genera 1,500 registros en tickets o asignaciones y permite hacer rollback mediante JSON';

    // Ruta fija del archivo JSON de datos para el rollback
    private $jsonFilePath;


    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->jsonFilePath =  sprintf(
            'storage/app/dump/%s/bulk_seed_data_%s.json',
            date('m'),
            date('H_i_s')
        );
    }

    /**
     * Execute the console command.
     */
    public function handle() 
    {
        // Si pasan la opción --rollback, ejecutamos la limpieza
        if ($this->option('rollback')) {
            $this->performRollback();
            return;
        }

        /**
         * Perfil usuario: quien creo el ticket
         * Perfil encargado: quien recibe o se le asignan los tickets
         */
        $option = $this->choice(
            '¿En qué perfil desdeas aplicar los datos de prueba?',
            ['usuario', 'encargado'],
            0
        );


        $userId = $this->ask('Ingresa el user_id que se asociará a los registros:');

        if (!is_numeric($userId)) {
            $this->error('El user_id debe ser un número válido.');
            return;
        }

        //Recuperar al usuario y su equipo
        $current_user = User::with('teams')->find($userId);
        
        if (!$current_user) {
            $this->error('No se encontro ningun usuario en la BD con este ID:' .$userId);
            return;
        }

        //Traer a los miembros
        $team = $current_user->teams->first() ?? null;
        $getMembersIds = $team?->members?->pluck('id')?->toArray() ?? [];

        $membersCtx = array_filter($getMembersIds, fn($id) => $id !== $current_user->id);
        $membersCtx = array_values($membersCtx);

        if (empty($membersCtx)) {
            $this->error('Para continuar con la prueba, debes añadir a uno o más integrantes a un equipo al que pertenezcas.');
            return;
        }

        $firstServiceId = TicketServiceEntity::first()?->id ?? null;

        if (!$firstServiceId) {
            $this->error('No se encontro un servicio en la tabla [tickets_services] para la prueba');
            return;
        }

        $this->info("Generando 1,500 registros en el perfil [{$option}] con el user_id: {$userId}...");

        $insertedIds = [];
        $assingData = [];
        $batchData = [];
        $chunks = 500; // Lotes de 500 para optimizar
        $total = 1500;
        $startDate = strtotime('2026-01-01 00:00:00');
        $endDate = time();

                    DB::beginTransaction();

                    try {
                        for ($i = 0; $i < $total; $i += $chunks) {

                            $randomTimestamp = rand($startDate, $endDate);
                            $randomUpdateTimestamp = rand($randomTimestamp, $endDate);

                            $batchData = []; 

                            for ($j = 0; $j < $chunks; $j++) {

                                $rowUserId = $current_user->id;

                                if ($option === 'encargado') {
                                    $rowUserId = $membersCtx[array_rand($membersCtx)];
                                }

                                $batchData[] = [
                                    'uid' => $this->generateUniqueUid(),
                                    'ticket_type_id'     => 1, 
                                    'ticket_service_id'  => $firstServiceId,
                                    'user_id'            => $rowUserId,
                                    'team_id'            => $current_user->teams?->first()?->id ?? 1,
                                    'ticket_priority_id' => rand(1,4),
                                    'status_id'          => rand(1,6),
                                    'title'              => 'Ticket de prueba masiva #' . ($i + $j + 1),
                                    'description'        => 'Descripción generada automáticamente para pruebas de carga.',
                                    'created_at'         => date('Y-m-d H:i:s', $randomTimestamp),    
                                    'updated_at'         => date('Y-m-d H:i:s', $randomUpdateTimestamp),
                                ];

                            }

                            DB::table('tickets')->insert($batchData);

                            $uidTicket = array_column($batchData, 'uid');
                            $ticketsIdsCreate = Ticket::whereIn('uid', $uidTicket)->pluck('id');

                            foreach ($ticketsIdsCreate as $value) {

                                $rowUserId = $current_user->id;

                                if ($option === 'usuario') {
                                    $rowUserId = $membersCtx[array_rand($membersCtx)];
                                }

                                $assingData[] = [
                                    'user_id'            => $rowUserId,
                                    'ticket_id'          => $value,
                                    'created_at'         => date('Y-m-d H:i:s', $randomTimestamp),    
                                    'updated_at'         => date('Y-m-d H:i:s', $randomUpdateTimestamp),
                                ];
                            
                                $insertedIds[] = $value;

                            }

                        }

                        //Guardar asignados
                        DB::table('tickets_users_assignations')->insert($assingData);

                        DB::commit();

                        // Asegurar que el directorio de destino exista antes de guardar el JSON
                        $fullPath = base_path($this->jsonFilePath);

                        $directory = dirname($fullPath);

                        if (!file_exists($directory)) {
                            mkdir($directory, 0755, true);
                        }


                        // Guardar los datos estructurados en el archivo JSON definitivo de respaldo
                        file_put_contents($fullPath, json_encode([
                            'option' => $option,
                            'tickets_ids' => $insertedIds
                        ], JSON_PRETTY_PRINT));

                        $this->info("¡1,500 registros creados con éxito en [{$option}]!");
                        $this->comment("Se ha guardado el archivo JSON de control. Para deshacer los registros de prueba, ejecuta: php artisan tickets:bulk-seed --rollback");

                    } catch (\Exception $e) {
                        DB::rollBack();
                        \Log::error($e->getMessage());
                        $this->error("Error en la inserción masiva: " . $e->getMessage());
                    }
    }

    /**
     * Lógica para el rollback leyendo el archivo JSON de respaldo
     */
    protected function performRollback()
    {
        $this->info("Buscando archivos de respaldo JSON para el rollback...");

        // Definimos la ruta de la carpeta del mes actual
        $directory = base_path('storage/app/dump/' . date('m'));

        if (!is_dir($directory)) {
            $this->error("No se encontró el directorio de respaldos: {$directory}");
            return;
        }

        // Buscamos todos los archivos JSON dentro de la carpeta del mes
        $files = glob($directory . '/bulk_seed_data_*.json');

        if (empty($files)) {
            $this->error("No se encontraron archivos JSON de respaldo para revertir en este mes.");
            return;
        }

        // Ordenamos para obtener el más reciente basado en la fecha de modificación
        usort($files, fn($a, $b) => filemtime($b) - filemtime($a));
        $latestFile = $files[0];

        $this->info("Leyendo archivo de respaldo: " . basename($latestFile));

        // Leemos y decodificamos el contenido del JSON
        $jsonContent = file_get_contents($latestFile);
        $data = json_decode($jsonContent, true);

        if (!isset($data['tickets_ids']) || empty($data['tickets_ids'])) {
            $this->error("El archivo JSON no contiene IDs válidos para eliminar.");
            return;
        }

        $ticketsIds = $data['tickets_ids'];
        $totalTickets = count($ticketsIds);

        if (!$this->confirm("¿Estás seguro de eliminar {$totalTickets} registros de prueba y sus asignaciones asociadas?")) {
            $this->info("Rollback cancelado.");
            return;
        }

        DB::beginTransaction();

        try {
            DB::table('tickets_users_assignations')->whereIn('ticket_id', $ticketsIds)->delete();

            Ticket::whereIn('id', $ticketsIds)->delete();

            DB::commit();

            if (file_exists($latestFile)) {
                unlink($latestFile);
            }

            $this->info("¡Rollback ejecutado con éxito! Se eliminaron {$totalTickets} registros de prueba.");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error al ejecutar el rollback: " . $e->getMessage());
        }
    }

    /**
     * Genera un UID para el ticket unico
     * @return string
     */
    protected function generateUniqueUid()
    {
        // Genera una cadena única de 36 caracteres y removemos los guiones si prefieres
        $uuid = str_replace('-', '', Str::uuid());
    
        // Retorna TKT + 32 caracteres hexadecimales aleatorios de alta seguridad
        return "TKT{$uuid}";
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
