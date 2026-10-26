<?php

namespace Modules\Services\Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Categories\Models\TicketCategory;
use Modules\Services\Models\TicketServiceEntity;
use Exception;

class ServicesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = TicketCategory::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        if (empty($categoryIds) || empty($userIds)) {
            $this->command->error('Primero debes sembrar Categorías y Usuarios para poder crear servicios.');
            return;
        }

        $user = User::find(2362);
        $colors = ['#E2C299', '#6CD2EC', '#FFBDB2', '#B2A2FF', '#A3EAD8'];
        $templates = ['default', 'advanced', 'standard', 'custom'];

        $horaInicioPrueba = now(); 

        $totalRecords = 50000;
        $chunkSize = 1000; 
        $chunks = $totalRecords / $chunkSize;

        $this->command->info("Iniciando la creación de {$totalRecords} servicios de tickets para pruebas de estrés...");

        $bar = $this->command->getOutput()->createProgressBar($totalRecords);
        $bar->start();

        DB::beginTransaction();

        try {
            // Arreglo en memoria para vigilar y retener los uids generados y evitar duplicados
            $generatedUids = [];

            for ($i = 0; $i < $chunks; $i++) {
                $batchData = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    
                    // Asegurar unicidad del uid en este lote
                    do {
                        $uid = 'SRV' . strtoupper(Str::random(5));
                    } while (in_array($uid, $generatedUids));

                    $generatedUids[] = $uid;

                    $colorAleatorio = $colors[array_rand($colors)];
                    $randomCategory = fake()->randomElement($categoryIds);
                    $randomUser = fake()->randomElement($userIds);

                    $batchData[] = [
                        'uid'           => $uid,
                        'name'          => fake()->sentence(4),
                        'description'   => fake()->paragraph(),
                        'category_id'   => $randomCategory,
                        'department_id' => $user?->department_id ?? 1, // Evita errores de NOT NULL
                        'status_id'     => 1, // Asumiendo 1 como activo por defecto
                        'template'      => fake()->randomElement($templates),
                        'color'         => $colorAleatorio,
                        'supervisor'    => 0,
                        'created_by'    => 2362,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }

                // Inserción masiva optimizada por bloques de 1,000
                DB::table('tickets_services')->insert($batchData);
                $bar->advance($chunkSize);
            }

            DB::commit();
            $bar->finish();
            $this->command->info("\n¡Prueba de estrés de servicios completada con éxito!");

            if ($this->command->confirm('¿Deseas eliminar todos los registros de servicios creados en esta prueba?', false)) {
                $this->command->info('Borrando registros de la prueba...');
                
                $borrados = DB::table('tickets_services')
                    ->where('created_at', '>=', $horaInicioPrueba)
                    ->delete();

                $this->command->info("Se eliminaron correctamente {$borrados} servicios de prueba.");
            }

        } catch (Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            $this->command->error("\nOcurrió un error durante la inserción. Se aplicó Rollback.");
            $this->command->error("Error: " . $e->getMessage());
        }
    }
}