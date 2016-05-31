<?php

namespace App\Services\Signups;

use App\Models\Invite;
use App\Models\Invitee;

/**
 * Handles the signing up business logic
 */
class ManagesSignups
{
    protected $invitees;
    protected $invites;
    protected $storedInvitee;

    public function __construct(Invitee $invitees, Invite $invites)
    {
        $this->invitees = $invitees;
        $this->invites = $invites;
    }

    /**
     * Takes in invitee and invite information and creates models.
     * @param  array $invitee An Array of invitee information.
     * @param  array  $invites A multidimensional array of invite information.
     * @return ManagesSignups
     */
    public function store($invitee, $invites = [])
    {
        $invitee = $this->invitees->create($invitee);
        $id = $invitee->id;
        foreach ($invites as $invite => $signedup) {
            $invitee->invites()->create(['type' => $invite]);
        }
        $this->storedInvitee = $invitee;
        return $this;
    }

    public function hasAlreadySignedUp($email)
    {
        return $this->invitees->exists($email);
    }

    /**
     * Gets the value of invitees.
     *
     * @return mixed
     */
    public function getInvitees()
    {
        return $this->storedInvitee;
    }

    /**
     * Gets the value of invites.
     *
     * @return mixed
     */
    public function getInvites()
    {
        return $this->invites;
    }

}
