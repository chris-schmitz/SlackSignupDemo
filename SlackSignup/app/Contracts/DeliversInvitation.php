<?php

namespace App\Contracts;

use App\Models\Invitee;

interface DeliversInvitation 
{
    /**
     * Sends an invitation to the particular invitee.
     * @param  Invitee $invitee The model containing the information for the person to be invited.
     * @return boolean           Boolean true if the invitation is successfully sent.
     */
    public function deliver(Invitee $invitee);
}