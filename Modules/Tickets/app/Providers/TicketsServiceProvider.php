<?php

namespace Modules\Tickets\Providers;

use Modules\Tickets\Repositories\Interfaces\ITicketRepo;
use Modules\Tickets\Repositories\TicketRepo;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
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
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }
}
