<?php

use App\Events\SuccessfulSignup;
use App\Listeners\NotifySlackChannel;
use App\Models\Invite;
use App\Models\Invitee;
use App\Services\Signups\ManagesSignups;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class NotifySlackChannelTest extends TestCase
{
    use DatabaseTransactions;

    // What should the notify slack channel object do?
    // get the name of the person who's just requested an invite
    // pull the slack api token from the env file
    // construct the url request url needed
    // construct a message for the channel
    // post to slack

    /**
     * Gets the name of the person requesting the invite.
     *
     * @test
     * @return void
     */
    public function sends_notification()
    {
        $invitee = Invitee::make(['first_name' => 'chris', 'last_name' => 'schmitz', 'email' => 'schmitz.chris@gmail.com']);
        $invite = Invite::make(['type' => 'slack', 'invitee_id' => $invitee->getId() ]);
        $event = new SuccessfulSignup($invitee);

        $notification = new NotifySlackChannel;
        $sent = $notification->handle($event);
        dd($notification, $sent);
        $this->assertEquals(
            $sent,
            true
        );
    }
}
