<?php

namespace App\Observers;

use App\Models\Job;

class JobObserver
{
    /**
     * Handle the Job "created" event.
     *
     * @param  \App\Models\Job  $Job
     * @return void
     */
    public function created(Job $Job)
    {
        clearSiteCaching();
    }

    /**
     * Handle the Job "updated" event.
     *
     * @param  \App\Models\Job  $Job
     * @return void
     */
    public function updated(Job $Job)
    {
        clearSiteCaching();
    }

    /**
     * Handle the Job "deleted" event.
     *
     * @param  \App\Models\Job  $Job
     * @return void
     */
    public function deleted(Job $Job)
    {
        clearSiteCaching();
    }

    /**
     * Handle the Job "restored" event.
     *
     * @param  \App\Models\Job  $Job
     * @return void
     */
    public function restored(Job $Job)
    {
        //
    }

    /**
     * Handle the Job "force deleted" event.
     *
     * @param  \App\Models\Job  $Job
     * @return void
     */
    public function forceDeleted(Job $Job)
    {
        //
    }
}
