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
    public function canInstanitateManager()
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
    // public function previously_signed_up_invitee_shows_as_already_having_signed_up(){
    //     $invite = new Invite;
    //     $invitee = new Invitee;
    //     $newInvitee = $invitee->create(['first_name' => 'test', 'last_name' => 'person', 'email' => 'test@lol.com']);
    //     $manager = new ManagesSignups($invitee);

    //     $this->assertTrue($manager->hasAlreadySignedUp($newInvitee->email));

    // }

    /**
     * Invitees added to the signup manager can be returned.
     * @test
     */
    public function invitees_created_have_same_name_format()
    {
        // This def doesn't seem like the test we should use. What all should we actually test?

        // I'm assuming we can do these with mocks instead of creating the actual database records
        // Come back after getting everything else working and learn/replace this with mocks
        $chris = ['first_name' => 'Zoe', 'last_name' => 'Dog', 'email' => 'zoe@chrisandruthie.com'];
        $invites = ['meetup', 'slack'];

        $manager = new ManagesSignups(new Invitee, new Invite);
        $manager->store($chris, $invites);

        $this->assertEquals($manager->getInvitees()->get()->first()->fullName(), $chris['first_name'] . " " . $chris['last_name']);
    }

}
