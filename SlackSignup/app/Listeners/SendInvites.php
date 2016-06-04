<?php

namespace App\Listeners;

use App\Events\SuccessfulSignup;
use App\Services\Invitations\SendsMeetupInvitations;
use App\Services\Invitations\SendsSlackInvitations;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvites implements ShouldQueue
{
    protected $slackInviter;
    protected $meetupInviter;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SendsSlackInvitations $slackInviter, SendsMeetupInvitations $meetupInviter)
    {
        //
        $this->slackInviter = $slackInviter;
        $this->meetupInviter = $meetupInviter;
    }

    /**
     * Handle the event.
     *
     * @param  SuccessfulSignup  $event
     * @return void
     */
    public function handle(SuccessfulSignup $event)
    {
        $this->invitee = $event->invitee();
        $me = $this;

        // I don't like this, it seems messy. Is there a better way of
        // delivering the invitation per invite type?
        $this->invitee->invites->each(function ($invite) use ($me) {
            if ($invite->type == 'meetup') {
                $me->meetupInviter->deliver($me->invitee);
            } else if ($invite->type == 'slack') {
                $me->slackInviter->deliver($me->invitee);
            }
        });
    }
}
