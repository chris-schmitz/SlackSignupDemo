<?php

namespace App\Services\Invitations;

use App\Contracts\DeliversInvitation;
use App\Models\Invitee;

class SendsMeetupInvitations implements DeliversInvitation {
    
    public function deliver(Invitee $invitee){
        \Log::info('invite ' . $invitee->fullName() . ' to meetup');
    }
}