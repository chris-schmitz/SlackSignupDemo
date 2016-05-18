<?php

namespace App\Listeners;

use App\Events\SuccessfulSignup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySlackChannel
{
    /**
     * @var App\Models\Invitee
     */
    protected $invitee;

    /**
     * The POST data payload to send to slack
     * @var array
     */
    protected $payload;

    /**
     * The slack api url to use
     * @var [type]
     */
    protected $url;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->buildUrl();
    }

    /**
     * Handle the event.
     *
     * @param  SuccessfulSignup  $event
     * @return void
     */
    public function handle(SuccessfulSignup $event)
    {
        $this->invitee = $event->invitee();

        $messageBody = $this->getInviteeName() . " has been invited to slack.";

        $this->buildDataPayload($messageBody);
        $this->sendNotification();
    }

    /**
     * Assembles the data payload to send in the post request.
     * @param  string $message The message to send the slack channel.
     *                         Note that because this class only sends simple messages we can pass in the message
     *                         as a string. If we want to send more complex messages or modularize this so that we
     *                         can use it to send anything to slack, we should refactor how this payload is built.
     * @return $this
     */
    protected function buildDataPayload($message){
        // hmmmmm, is the channel id really something to keep in a env config? 
        // If we keep it here or even in a database table there's a chance the channel 
        // id could change. It's not likely, but there's a chance. For now, build it out
        // with the channel id in the env, but create a task to circle back and write a service
        // for pulling it from slack dynamically 

        $this->payload = [
            'token' => env('SLACK_API_TOKEN'),
            'channel' => env('SLACK_API_MESSAGE_CHANNEL'),
            'text' => $message
        ];
        return $this;
    }

    /**
     * Return the invitee's full name.
     * @return string Full Name
     */
    protected function getInviteeName(){
        return $this->invitee->fullName();
    }

    /**
     * Construct the API url.
     * @return null
     */
    protected function buildUrl(){
        $basePath = env('SLACK_API_HOST');
        $postUri = "chat.postMessage";
        $this->url = $basePath . $postUri;
    }

    /**
     * Make API call to slack.
     * 
     * @throws  Exception
     * @return null
     */
    protected function sendNotification(){
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->payload);
        $sent = curl_exec($ch);

        if($sent == false){
            throw new \Exception('There was an error notifying Slack.');
        }
    }

}
