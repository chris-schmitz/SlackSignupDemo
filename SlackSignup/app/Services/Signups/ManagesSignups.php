<?php

namespace App\Services\Signups;

use App\Invite;
use App\Invitee;

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

    public function handle($invitee, $invites = [])
    {
        $invitee = $this->invitees->create($invitee);
        $id = $invitee->id;
        foreach ($invites as $invite) {
            $invitee->invites()->create(['type' => $invite]);
        }

        dd($invitee->find($id)->with('invites')->get());
    }
}
