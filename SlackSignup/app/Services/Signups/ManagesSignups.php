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

    public function __construct(Invitee $invitees, Invite $invites)
    {
        $this->invitees = $invitees;
        $this->invites = $invites;
    }

    public function store($invitee, $invites = [])
    {
        $invitee = $this->invitees->create($invitee);
        $id = $invitee->id;
        foreach ($invites as $invite) {
            $invitee->invites()->create(['type' => $invite]);
        }
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
        return $this->invitees;
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
