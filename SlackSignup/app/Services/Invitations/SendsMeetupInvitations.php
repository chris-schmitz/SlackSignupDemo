<?php

namespace App\Services\Invitations;

use App\Contracts\DeliversInvitation;
use App\Models\Invitee;
use Illuminate\Support\Facades\Mail;

class SendsMeetupInvitations implements DeliversInvitation
{
    protected $invitee;
    protected $payload = [];

    // This seems like something we'd want to make dynamic so that we could use this
    // tool for multiple meetup groups. Build it out so that we know it works and then come
    // back to refactor it to make it modular.
    protected $meetupName = "Saint Louis Full Stack Web Development";

    /**
     * The invite url to send to the invitee.
     * Note that meetup does _not_ have a way for 3rd parties to invite people
     * to join (I confirmed by asking them via google group). The best we can do
     * is to send the invitee an email wit a link inviting them to join or maybe
     * a link just to the meetup group homepage. This is the link to join. Note that
     * it comes from your account (i.e. in this case it says "Chris Schmitz invites
     * you to join") so it may be worth creating a generic meetup account to act as
     * the inviter.
     * @var string
     */
    protected $inviteLink = "http://meetu.ps/c/2tSFR/g6V8H/f";

    public function deliver(Invitee $invitee)
    {
        $this->invitee = $invitee;
        $this->buildPayload();
        $this->sendInvite();
        return true;
    }

    /**
     * Put together the pieces of information needed to send the email.
     * @return void
     */
    protected function buildPayload()
    {
        $this->payload['name'] = $this->invitee->firstName();
        $this->payload['email'] = $this->invitee->email();
        $this->payload['subject'] = sprintf("Invite to the %s", $this->meetupName);
        $this->payload['message'] = sprintf("You've requested an invite to the %s meetup group. Please follow the link to join.", "Saint Louis Full Stack Web Development");
        $this->payload['link'] = $this->inviteLink;
    }

    /**
     * Sends the invite email.
     * @return void
     */
    protected function sendInvite()
    {
        $me = $this;
        $payload = $this->payload;
        Mail::send('emailtemplates.tests.mailguntest', ['payload' => $payload], function ($m) use ($payload, $me) {
            $m->from($me->getSenderEmail(), $me->getSenderName());
            $m->to($payload['email'], $payload['name'])->subject($payload['subject']);
        });
    }

    protected function getMeetupName()
    {
        return $this->meetupName;
    }

    protected function getInviteLink()
    {
        return $this->inviteLink;
    }

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
