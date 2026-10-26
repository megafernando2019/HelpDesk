<?php

namespace Modules\Categories\Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class CategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::with('teams')->find(2362);

        if (!$user) {
            $this->command->error('El usuario especificado (ID 2362) no existe en la BD.');
            return;
        }

        $user_team_id = $user->teams?->first()?->id ?? null;
        $colors = ['#E2C299', '#6CD2EC', '#FFBDB2', '#B2A2FF', '#A3EAD8'];

        $horaInicioPrueba = now(); 

        $totalRecords = 50000;
        $chunkSize = 1000; 
        $chunks = $totalRecords / $chunkSize;

        $this->command->info("Iniciando la creación de {$totalRecords} categorías para pruebas de estrés...");

        $bar = $this->command->getOutput()->createProgressBar($totalRecords);
        $bar->start();

        DB::beginTransaction();

        try {
            // Arreglo en memoria para vigilar y retener los uids generados y evitar duplicados en el lote
            $generatedUids = [];

            for ($i = 0; $i < $chunks; $i++) {
                $batchData = [];

                for ($j = 0; $j < $chunkSize; $j++) {
                    
                    // Ciclo seguro: si por probabilidad se repite, vuelve a generar otro al instante
                    do {
                        $uid = 'CAT' . strtoupper(Str::random(5));
                    } while (in_array($uid, $generatedUids));

                    // Lo guardamos en el registro local
                    $generatedUids[] = $uid;

                    $colorAleatorio = $colors[array_rand($colors)];

                    $batchData[] = [
                        'uid'           => $uid,
                        'name'          => fake()->sentence(4),
                        'description'   => fake()->paragraph(),
                        'status'        => 1,
                        'department_id' => $user->department_id ?? 1, // Evita errores de NOT NULL
                        'team_id'       => $user_team_id,
                        'created_by'    => $user->id,
                        'color'         => $colorAleatorio, 
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }

                // Inserción masiva limpia por cada 1,000 registros
                DB::table('tickets_categories')->insert($batchData);
                $bar->advance($chunkSize);
            }

            DB::commit();
            $bar->finish();
            $this->command->info("\n¡Prueba de estrés completada con éxito!");

            // Preguntar en consola si deseas borrar la prueba inmediatamente
            if ($this->command->confirm('¿Deseas eliminar todos los registros creados en esta prueba de estrés ahora mismo?', false)) {
                $this->command->info('Borrando registros de la prueba...');
                
                $borrados = DB::table('tickets_categories')
                    ->where('created_at', '>=', $horaInicioPrueba)
                    ->delete();

                $this->command->info("Se eliminaron correctamente {$borrados} registros de prueba.");
            }

        } catch (Exception $e) {
            DB::rollBack();
            $this->command->error("\nOcurrió un error durante la inserción. Se aplicó Rollback.");
            $this->command->error("Error: " . $e->getMessage());
        }
    }
}