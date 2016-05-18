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

    public function __construct()
    {
        $this->epoch = time();
        // Ok, this is DEFINITELY getting to the point where we should pull this programatically. 
        // maybe we have a service that allows us to set the name of the target channel in the envi (e.g. `general`)
        // and it will lookup the correct id for the given slack team
        $this->channel = env('SLACK_GENERAL_CHANNEL');
        $this->token = env('SLACK_API_TOKEN');
        $this->apiHost = env('SLACK_API_HOST');
    }


    public function deliver(Invitee $invitee){
        $this->invitee = $invitee;
        \Log::info('invite ' . $invitee->fullName() . ' to slack');
        $this->buildPayload();
        $this->constructUrl();
        $this->sendInvite();
        // construct and send the curl request
        // throw custom exception(s) if anything goes wrong
    }

    protected function buildPayload(){
        $this->payload = [
            'channel' => $this->channel,
            'token' => $this->token,
            'first_name' => $this->getInviteeFirstName(),
            'email' => $this->getInviteeEmail(),
            'set_active' => true,
            '_attempts' => 1 // should we look for resends and increment this?
        ];
    }

    protected function constructUrl(){
        $this->url = sprintf("%s%s?t=%s", $this->apiHost, $this->apiEndpoint, $this->epoch);
    }

    protected function sendInvite(){
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->payload);
        $sent = curl_exec($ch);

        if($sent == false){
            throw new \Exception("There was an error sending the Invitee's invitation to Slack.");
        }
    }

    protected function getInviteeFirstName(){
        return $this->invitee->firstName();
    }

    protected function getInviteeEmail(){
        return $this->invitee->email();
    }
}