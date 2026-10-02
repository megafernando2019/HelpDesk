<?php

namespace Modules\User\app\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateChangeRolePermission extends Command
{
    /**
     * The name and signature of the console command.
     * ejemplo de uso: php artisan permission:create-change-role 15* el ID del usuario como bandera
     */
    protected $signature = 'permission:create-change-role {user_id?}';

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
    public function handle()
    {
        $userId = $this->argument('user_id');

        $user = User::find($userId);

        if (!$user) {
            $this->error("No existe el usuario con ID {$userId}.");

            return self::FAILURE;
        }

        $permission = Permission::firstOrCreate([
            'name' => 'manage-user-roles',
            'guard_name' => 'web',
        ]);

        $user->givePermissionTo($permission);

        $this->info("Permiso 'manage-user-roles' asignado correctamente.");
        $this->info("Usuario: {$user->name} (ID: {$user->id})");

        return self::SUCCESS;
    }

    /**permission:create-change-role
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
