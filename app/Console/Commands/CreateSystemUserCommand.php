<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSystemUserCommand extends Command
{
    /**
     * El nombre y firma del comando en consola.
     */
    protected $signature = 'tickets:create-system-user';

    /**
     * Descripción del comando.
     */
    protected $description = 'Crea el usuario por defecto del sistema (Bot/Webmaster) para las tareas automáticas.';

    /**
     * Ejecuta la lógica del comando.
     */
    public function handle()
    {
        $idSSO = 'SYSTEM_BOT_01';

        // Verificamos si ya existe el usuario en la base de datos
        $existingUser = User::where('id_sso', $idSSO)->first();

        if ($existingUser) {
            $this->info("El usuario del sistema ya está integrado en la base de datos.");
            return Command::SUCCESS;
        }

        // Si no existe, lo creamos con valores por defecto
        User::create([
            'id_sso'          => 'SYSTEM_BOT_01',
            'first_name'      => 'Sistema',
            'last_name'       => 'Automático (Bot)',
            'email'           => 'bot.helpdesk@megatravel.com.mx',
            'status_id'       => 1, 
            'role_id'         => 1, 
            'department_id'   => 1, 
            'user_type_id'    => 1,
            'password'        => 'htchd2t9193', 
            'active'          => 1,
            'admin'           => 1, 
        ]);

        $this->info("¡Usuario del sistema creado exitosamente!");

        return Command::SUCCESS;
    }
}
