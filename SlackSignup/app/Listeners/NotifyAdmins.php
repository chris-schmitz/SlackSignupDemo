<?php

namespace App\Listeners;

use App\Events\SuccessfulSignup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class NotifyAdmins
{
    /**
     * The admin emails to notify.
     * @var Illuminate\Support\Collection
     */
    protected $adminEmails;
    protected $invitee;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $emails = explode(',', env('MAIL_ADMINEMAILS'));
        $this->adminEmails = new Collection($emails);
    }

    /**
     * Handle the event.
     *
     * @param  SuccessfulSignup  $event
     * @return void
     */
    public function handle(SuccessfulSignup $event)
    {
        $invitee = $event->invitee();

        $me = $this;
        $this->adminEmails()->each(function ($email) use ($invitee, $me) {

            $invites = new Collection($invitee->invites()->get());
            $inviteArray = $invites->map(function ($inviteModel) {
                return $inviteModel->type;
            })->toArray();

            $inviteeName = $invitee->fullName();

            Mail::send('emailtemplates.adminInviteNotification', compact('inviteArray', 'inviteeName'), function ($m) use ($email, $inviteeName, $me) {
                $m->from($me->getSenderEmail(), $me->getSenderName())
                    ->to($email)
                    ->subject("$inviteeName has requested invites.");
            });
        });
        return true;
    }

    protected function adminEmails()
    {
        return $this->adminEmails;
    }

    // Consider extracting these to a trait so they can be include here, in `SendsMeetupInvitations`
    // and any other Sender.
    /**
     * Returns the email to use when sending emails from server.
     * @return string The site's email address.
     */
    protected function getSenderEmail()
    {
        return config('mail.from.address');
    }

    /**
     * Returns the name to use when sending emails from server.
     * @return string The site's email name.
     */
    protected function getSenderName()
    {
        return config('mail.from.name');
    }
}
