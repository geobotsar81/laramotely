<?php

namespace App\Console;

use App\Services\ArcScraperService;
use App\Services\JobScraperService;
use App\Services\NewsletterService;
use App\Services\WwrScraperService;
use App\Services\SimplyHiredService;
use App\Services\UkLaravelJobsService;
use App\Services\LarajobsScraperService;
use App\Services\LaranewsScraperService;
use App\Services\LinkedInScraperService;
use App\Services\ReedjobsScraperService;
use App\Services\RemoteokScraperService;
use App\Services\RemotiveScraperService;
use App\Services\GlassDoorScraperService;
use App\Services\LaravelIOScraperService;
use App\Services\CleverjobsScraperService;
use App\Services\LaravelLinkScraperService;
use Illuminate\Console\Scheduling\Schedule;
use App\Services\ZipRecruiterScraperService;
use App\Services\FirebaseNotificationService;
use App\Services\StackOverflowScraperService;
use App\Services\WorkingNomadsScraperService;
use App\Http\Controllers\NewsletterController;
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
        $schedule
            ->call(function () {
                $newsletter = new NewsletterService();
                $newsletter->sendEmails();
            })
            ->dailyAt("15:00");

        $schedule
            ->call(function () {
                $jobsScraper = new JobScraperService();
                $jobsScraper->scrape();
            })
            ->everyFiveMinutes();

        $schedule
            ->call(function () {
                $larajobsScraper = new LarajobsScraperService();
                $larajobsScraper->scrape();
            })
            ->hourlyAt(5);

        $schedule
            ->call(function () {
                $workingNomadsScraper = new WorkingNomadsScraperService();
                $workingNomadsScraper->scrape();
            })
            ->hourlyAt(10);

        $schedule
            ->call(function () {
                $wwrScraper = new WwrScraperService();
                $wwrScraper->scrape();
            })
            ->hourlyAt(15);

        /*$schedule
            ->call(function () {
                $zipRecruiterScraper = new ZipRecruiterScraperService();
                $zipRecruiterScraper->scrape();
            })
            ->hourlyAt(20);*/

        $schedule
            ->call(function () {
                $soScraper = new LaravelLinkScraperService();
                $soScraper->scrape();
            })
            ->hourlyAt(20);

        $schedule
            ->call(function () {
                $soScraper = new LaranewsScraperService();
                $soScraper->scrape();
            })
            ->hourlyAt(25);

        $schedule
            ->call(function () {
                $soScraper = new LaravelIOScraperService();
                $soScraper->scrape();
            })
            ->hourlyAt(28);

        $schedule
            ->call(function () {
                $glassDoorScraper = new GlassDoorScraperService();
                $glassDoorScraper->scrape();
            })
            ->hourlyAt(30);

        $schedule
            ->call(function () {
                $remoteokScraper = new RemoteokScraperService();
                $remoteokScraper->scrape();
            })
            ->hourlyAt(35);

        $schedule
            ->call(function () {
                $simplyHiredScraper = new SimplyHiredService();
                $simplyHiredScraper->scrape();
            })
            ->hourlyAt(40);

        $schedule
            ->call(function () {
                $remotiveScraper = new RemotiveScraperService();
                $remotiveScraper->scrape();

                $reedjobsScraper = new ReedjobsScraperService();
                $reedjobsScraper->scrape();
            })
            ->hourlyAt(45);

        $schedule
            ->call(function () {
                $cleverjobsScraper = new CleverjobsScraperService();
                $cleverjobsScraper->scrape();
            })
            ->hourlyAt(50);

        $schedule
            ->call(function () {
                $arcScraper = new ArcScraperService();
                $arcScraper->scrape();
            })
            ->hourlyAt(55);

        $schedule
            ->call(function () {
                $appNotifications = new FirebaseNotificationService();
                $appNotifications->sendJobNotifications();
            })
            ->hourlyAt(0);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . "/Commands");

        require base_path("routes/console.php");
    }
}
