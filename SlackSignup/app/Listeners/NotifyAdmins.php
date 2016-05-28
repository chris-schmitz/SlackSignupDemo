<?php

namespace App\Listeners;

use App\Events\SuccessfulSignup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdmins
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
     * @param  SuccessfulSignup  $event
     * @return void
     */
    public function handle(SuccessfulSignup $event)
    {
        // get list of admins,
        // - Should this be a config or a database table? It's not like we have a lot of changing admins and it's not like we're having the admins log in
        // - config would be simpler and we could always refactor later
        // send email
    }
}
