<?php

use App\Events\SuccessfulSignup;
use App\Listeners\NotifyAdmins;
use App\Models\Invite;
use App\Models\Invitee;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotifyAdminsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Gets the name of the person requesting the invite.
     *
     * @test
     * @return void
     */
    public function sendsNotification()
    {

        $invitee = Invitee::make(['first_name' => 'chris', 'last_name' => 'schmitz', 'email' => 'schmitz.chris@gmail.com']);
        $invite = Invite::make(['type' => 'slack', 'invitee_id' => $invitee->getId()]);
        $invite2 = Invite::make(['type' => 'meetup', 'invitee_id' => $invitee->getId()]);
        $invitee->save();
        $invitee->invites()->save($invite);
        $invitee->invites()->save($invite2);

        $event = new SuccessfulSignup($invitee);

        $notifier = new NotifyAdmins;

        $this->assertEquals($notifier->handle($event), true);
    }

    // would it make sense to do a send count test?
}
