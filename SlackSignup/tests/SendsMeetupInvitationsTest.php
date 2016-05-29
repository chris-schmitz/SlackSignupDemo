<?php

use App\Models\Invitee;
use App\Services\Invitations\SendsMeetupInvitations;

class SendsMeetupInvitationsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $invitee = Invitee::make(['first_name' => 'chris', 'last_name' => 'schmitz', 'email' => 'chris.schmitz.dev@gmail.com']);

        $sender = new SendsMeetupInvitations;

        $this->assertTrue($sender->deliver($invitee), true);
    }
}
