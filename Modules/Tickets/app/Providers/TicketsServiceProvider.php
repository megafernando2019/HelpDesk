<?php

namespace Modules\Tickets\Providers;

use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Modules\Tickets\Repositories\TicketRepo;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Tickets\Console\AutoCloseTicketsCommand;
use Modules\Tickets\Console\MigrateLegacyTicketLogs;
use Modules\Tickets\Console\SeedBulkTicketsCommand;
use Modules\Tickets\Services\TicketService;

class TicketsServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Tickets';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'tickets';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];


    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrateLegacyTicketLogs::class,
                AutoCloseTicketsCommand::class,
                SeedBulkTicketsCommand::class
            ]);
        }

        $this->app->bind(
            ITicketRepo::class,
            TicketRepo::class
        );

        $this->app->bind(
            TicketService::class
        );
    }

    /**
     * Define module schedules.
     * 
     * @param $schedule
     */
    protected function configureSchedules(Schedule $schedule): void
    {
        $schedule->command('tickets:auto-close')
        ->weekdays()
        ->at('23:59') 
        ->withoutOverlapping();
    }
}
