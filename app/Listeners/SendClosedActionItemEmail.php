<?php

namespace App\Listeners;

use App\Events\ActionItemClosed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendClosedActionItemEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActionItemClosed  $event
     * @return void
     */
    public function handle(ActionItemClosed $event)
    {
        //
    }
}
