<?php

namespace Modules\Categories\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Categories\Repositories\Interfaces\ITicketCategoryRepo;
use Modules\Categories\Repositories\TicketCategoryRepo;
use Modules\Categories\Services\TicketCategoryService;

class CategoriesServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Categories';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'categories';

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
            ITicketCategoryRepo::class,
            TicketCategoryRepo::class
        );

        $this->app->bind(
            TicketCategoryService::class
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
