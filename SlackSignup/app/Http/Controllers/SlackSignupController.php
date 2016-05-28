<?php

namespace App\Http\Controllers;

use App\Events\SuccessfulSignup;
use App\Services\Signups\ManagesSignups;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlackSignupController extends Controller
{
    protected $request;
    protected $signupManager;

    public function __construct(Request $request, ManagesSignups $signupManager)
    {
        $this->request = $request;
        $this->signupManager = $signupManager;
    }

    public function create()
    {
        return view('slack.signup.create');
    }

    public function store()
    {
        // add to validation
        // at least one invite
        $this->validate($this->request, [
            'email' => 'required|email', // note that we're not using the unique validator. If the email already exists we want to give the option to resend invites.
        ]);

        $requestedInviteRefresh = $this->request->get('resend') ?: false;
        $email = $this->request->get('email');

        if ($this->signupManager->hasAlreadySignedUp($email) && !$requestedInviteRefresh) {
            return $this->response("You have already submitted a signup request.", 409);
        }

        $message = $this->storeDataIfNew();
        $message = $message ?: 'Invites have been resent.';

        event(new SuccessfulSignup($this->signupManager->getInvitees()));

        return $this->response($message, 200);
    }

    protected function storeDataIfNew()
    {
        if ($this->signupManager->hasAlreadySignedUp($this->request->get('email'))) {
            return;
        }
        $invitee = [
            'first_name' => $this->request->get('name')['first'],
            'last_name' => $this->request->get('name')['last'],
            'email' => $this->request->get('email'),
        ];

        $invitesRequest = $this->request->get('invites');
        $invites = collect($invitesRequest)->filter(function ($requested, $key) {
            return $requested === true;
        })
            ->map(function ($invite, $invitedTo) {
                return $invite;
            })
        ;

        $this->signupManager->store($invitee, $invites);

        return 'Signup successful.';
    }

}
