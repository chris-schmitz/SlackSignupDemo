<?php

namespace App\Services\Invitations;

use App\Contracts\DeliversInvitation;
use App\Models\Invitee;

class SendsSlackInvitations implements DeliversInvitation
{
    protected $epoch;
    protected $channel;
    protected $invitee;
    protected $payload;
    protected $apiHost;
    protected $apiEndpoint = 'users.admin.invite?t=';
    protected $url;
    protected $slackTeamUrl;
    protected $slackTeamName;

    public function __construct()
    {
        $this->epoch = time();
        // Ok, this is DEFINITELY getting to the point where we should pull this programatically.
        // maybe we have a service that allows us to set the name of the target channel in the envi (e.g. `general`)
        // and it will lookup the correct id for the given slack team
        $this->channel = env('SLACK_GENERAL_CHANNEL');
        $this->token = env('SLACK_API_TOKEN');
        $this->apiHost = env('SLACK_API_HOST');
        $this->slackTeamUrl = env('SLACK_TEAM_URL');
        $this->slackTeamName = env('SLACK_TEAM_NAME');
    }

    public function deliver(Invitee $invitee)
    {
        $this->invitee = $invitee;
        $this->buildPayload();
        $this->constructUrl();
        $this->addInviteeToSlackTeam();
        $this->sendInvite();
    }

    protected function buildPayload()
    {
        $this->payload = [
            'channel' => $this->channel,
            'token' => $this->token,
            'first_name' => $this->getInviteeFirstName(),
            'email' => $this->getInviteeEmail(),
            'set_active' => true,
            '_attempts' => 1, // should we look for resends and increment this?
        ];
    }

    protected function constructUrl()
    {
        $this->url = sprintf("%s%s?t=%s", $this->apiHost, $this->apiEndpoint, $this->epoch);
    }

    protected function addInviteeToSlackTeam()
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->payload);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $sent = curl_exec($ch);

        if ($sent !== true) {
            throw new \Exception("There was an error sending the Invitee's invitation to Slack.");
        }
    }

    protected function sendInvite()
    {
        $payload['name'] = $this->getInviteeFirstName();
        $payload['email'] = $this->getInviteeEmail();
        $payload['teamName'] = $this->slackTeamName;
        $payload['teamLink'] = $this->slackTeamUrl;

        // Mail::send('')

        // get the users' name and email
        // get the link to the slack team
        // send them an email with a link to the slack team notifying them that they're added
    }

    protected function getInviteeFirstName()
    {
        return $this->invitee->firstName();
    }

    protected function getInviteeEmail()
    {
        return $this->invitee->email();
    }
}
