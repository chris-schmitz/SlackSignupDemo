<?php

namespace App\Http\Controllers;

use App\Services\Signups\ManagesSignups;

class DevController extends Controller
{
    protected $signupManager;

    public function __construct(ManagesSignups $signupManager)
    {
        $this->signupManager = $signupManager;
    }

    public function test()
    {
        $invitee = ['first_name' => 'chris', 'last_name' => 'schmitz', 'email' => 'schmitz.chris@gmail.com'];
        $invites = ['slack', 'meetup'];
        $this->signupManager->handle($invitee, $invites);
    }
}
