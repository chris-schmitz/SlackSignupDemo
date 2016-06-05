<?php

use App\Models\Invite;
use App\Models\Invitee;
use App\Services\Signups\ManagesSignups;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SignupManagerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Creating a new signup manager.
     *
     * @test
     * @return void
     */
    public function can_instanitate_manager()
    {
        $invitee = new Invitee;
        $invite = new Invite;
        $manager = new ManagesSignups($invitee, $invite);

        $this->assertSame($invitee, $manager->getInvitees());
        $this->assertSame($invite, $manager->getInvites());
    }

    /**
     * @test
     */
    public function can_store_invitee_and_invites(){
        $inviteeData = ['first_name' => 'chris', 'last_name' => 'schmitz', 'email' => 'schmitz.chris@gmail.com'];
        $invite1 = ['type' => 'meetup'];
        $invite2 = ['type' => 'slack'];

        $invitee = new Invitee;
        $invite = new Invite;
        $manager = new ManagesSignups($invitee, $invite);

        $manager->store($inviteeData, [$invite1, $invite2]);
    }

}
