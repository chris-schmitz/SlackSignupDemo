<?php

use App\Events\SuccessfulSignup;
use App\Listeners\SendInvites;
use App\Models\Invite;
use App\Models\Invitee;
use App\Services\Invitations\SendsMeetupInvitations;
use App\Services\Invitations\SendsSlackInvitations;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SendInvitesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $invitee = Invitee::make(['first_name' => 'chris', 'last_name' => 'schmitz', 'email' => 'chris.schmitz@skeletonkey.com']);

        $invite1 = new Invite;
        $invite1->type = 'slack';
        $invitee->invites()->save($invite1);
        // $invite2 = new Invite;
        // $invite2->type = 'meetup';
        // $invitee->invites()->save($invite2);

        $event = new SuccessfulSignup($invitee);
        $slackInviter = new SendsSlackInvitations;
        $meetupInviter = new SendsMeetupInvitations;

        $sender = new SendInvites($slackInviter, $meetupInviter);
        $sender->handle($event);
        // how would you assert a result here?
        $this->assertTrue(true);
    }
}
