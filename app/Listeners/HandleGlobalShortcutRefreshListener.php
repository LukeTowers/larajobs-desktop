<?php

namespace App\Listeners;

use App\Jobs\FetchNewJobs;

class HandleGlobalShortcutRefreshListener
{
    /**
     * Handle the event.
     */
    public function handle()
    {
        FetchNewJobs::dispatchSync(true);
    }
}
