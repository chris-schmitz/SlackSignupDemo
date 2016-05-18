<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Invite;
use App\Models\Invitee;
use Illuminate\Queue\SerializesModels;

class SuccessfulSignup extends Event
{
    protected $invitee;

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invitee $invitee)
    {
        $this->invitee = $invitee;
    }


    /**
     * Gets the value of invitee.
     *
     * @return mixed
     */
    public function invitee()
    {
        return $this->invitee;
    }

}
