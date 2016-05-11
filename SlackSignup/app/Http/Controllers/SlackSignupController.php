<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlackSignupController extends Controller
{
    protected $signups;
    protected $request;

    public function __construct(Signup $signups, Request $request)
    {
        $this->signups = $signups;
        $this->request = $request;
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

        $resendInvites = $this->request->get('resend') ?: false;
        $email = $this->request->get('email');

        if ($this->hasAlreadySignedUp($email) && !$resendInvites) {
            return $this->response("You have already submitted a signup request.", 409);
        }

        $message = $this->handleInviteRequest($resendInvites);

        // fire event "SuccessfulSignup" // events send out invites and do whatever accompanying logic we want that is ancillary to this request

        return $this->response($message, 200);
    }

    protected function hasAlreadySignedUp($email)
    {
        return $this->signups->exists($email)->count() > 0;
    }

    protected function handleInviteRequest($resendInvites = false)
    {
        $message = null;

        if (!$resendInvites) {

            $signupData = [
                'first_name' => $this->request->get('name')['first'],
                'last_name' => $this->request->get('name')['last'],
                'email' => $this->request->get('email'),
            ];

            $this->signups->persist($signupData);
            $message = 'Signup successful.';

        } else {
            $message = 'Invites resent.';
        }
        return $message;
    }
}
