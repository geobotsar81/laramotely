<?php

namespace App\Console;

use App\Services\ArcScraperService;
use App\Services\WwrScraperService;
use App\Services\LarajobsScraperService;
use App\Services\RemoteokScraperService;
use App\Services\RemotiveScraperService;
use Illuminate\Console\Scheduling\Schedule;
use App\Services\StackOverflowScraperService;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $larajobsScraper=new LarajobsScraperService();
            $larajobsScraper->scrape("https://larajobs.com");
        })
        ->hourlyAt(5);

        $schedule->call(function () {
            $wwrScraper=new WwrScraperService();
            $wwrScraper->scrape("https://weworkremotely.com/remote-jobs/search?term=laravel");
        })
        ->hourlyAt(15);

        $schedule->call(function () {
            $soScraper=new StackOverflowScraperService();
            $soScraper->scrape("https://stackoverflow.com/jobs?q=laravel&sort=p");
        })
        ->hourlyAt(25);

        $schedule->call(function () {
            $remoteokScraper=new RemoteokScraperService();
            $remoteokScraper->scrape("https://remoteok.io/api");
        })
        ->hourlyAt(35);

        $schedule->call(function () {
            $remotiveScraper=new RemotiveScraperService();
            $remotiveScraper->scrape("https://remotive.io/api/remote-jobs?search=laravel");
        })
        ->hourlyAt(45);

        $schedule->call(function () {
            $arcScraper=new ArcScraperService();
            $arcScraper->scrape("https://arc.dev/remote-jobs/laravel");
        })
        ->hourlyAt(45);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
