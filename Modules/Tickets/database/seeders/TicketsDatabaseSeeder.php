<?php

namespace Modules\Tickets\Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Services\Models\TicketServiceEntity;
use Exception;

class TicketsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $userIds = User::pluck('id')->toArray();
        $serviceIds = TicketServiceEntity::pluck('id')->toArray();

        if (empty($userIds) || empty($serviceIds)) {
            $this->command->error('Primero debes sembrar Usuarios y Servicios de Tickets para poder crear tickets.');
            return;
        }

        $totalRecords = 50000;
        $chunkSize = 1000; 
        $chunks = $totalRecords / $chunkSize;

        $this->command->info("Iniciando la creación de {$totalRecords} tickets para pruebas de estrés...");

        $bar = $this->command->getOutput()->createProgressBar($totalRecords);
        $bar->start();

        DB::beginTransaction();

        try {

            $startOfYearTimestamp = Carbon::now()->startOfYear()->timestamp;
            $currentTimestamp = Carbon::now()->timestamp;
            
            $generatedUids = [];

            for ($i = 0; $i < $chunks; $i++) {
                $batchData = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    
            
                    do {
                        $uid = 'TKT' . strtoupper(Str::random(6));
                    } while (in_array($uid, $generatedUids));

                    $randomTimestamp = rand($startOfYearTimestamp, $currentTimestamp);
                    $randomDate = Carbon::createFromTimestamp($randomTimestamp);

                    $generatedUids[] = $uid;

                    $batchData[] = [
                        'uid'                => $uid,
                        'ticket_type_id'     => 1, 
                        'ticket_service_id'  => fake()->randomElement($serviceIds),
                        'ticket_priority_id' => rand(1, 4),
                        'user_id'            => 2362,
                        'status_id'          => rand(1, 6), 
                        'title'              => 'seederfaker',
                        'description'        => fake()->paragraph(),
                        'team_id'            => 1,
                        'created_at'         => $randomDate,
                        'updated_at'         => $randomDate,
                    ];
                }

                // Inserción masiva limpia por bloques de 1,000 registros
                DB::table('tickets')->insert($batchData);
                $bar->advance($chunkSize);
            }

            DB::commit();
            $bar->finish();
            $this->command->info("\n¡Prueba de estrés de tickets completada con éxito!");

            if ($this->command->confirm('¿Deseas eliminar todos los registros de tickets creados en esta prueba?', false)) {
                $this->command->info('Borrando registros de la prueba...');
                
                $borrados = DB::table('tickets')
                    ->where('created_at', '>=', now()->subMinutes(30))
                    ->delete();

                $this->command->info("Se eliminaron correctamente {$borrados} tickets de prueba.");
            }

        } catch (Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());

            $this->command->error("\nOcurrió un error durante la inserción. Se aplicó Rollback.");
            $this->command->error("Error: " . $e->getMessage());
        }
    }
}