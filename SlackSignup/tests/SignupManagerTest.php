<?php

use App\Models\Invite;
use App\Models\Invitee;
use App\Services\Signups\ManagesSignups;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

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
     * A user who has already signed up will show as so.
     * @test
     * @return boolean True or False indication of previous signup state.
     */
    public function previously_signed_up_invitee_shows_as_already_having_signed_up(){
        $invite = new Invite;
        $invitee = new Invitee;
        $newInvitee = $invitee->create(['first_name' => 'test', 'last_name' => 'person', 'email' => 'test@lol.com']);
        $manager = new ManagesSignups($invitee, $invite);
        
        $this->assertTrue($manager->hasAlreadySignedUp($newInvitee->email));

    }

    // store
}
