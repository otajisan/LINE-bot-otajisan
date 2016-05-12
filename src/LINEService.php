<?php

//use Curl;

class LINEService
{
    const TRIAL_API_URL = 'https://trialbot-api.line.me/v1/';

    public function receive_message()
    {
        echo ">>>> message received.";
    }

    public function post_message()
    {
        $header = $this->create_header();
        $curl = new Curl();
        $post = json_encode(array(
            'to' => $to,
        ));
        $curl->post($header, $body);
    }

    protected function create_header()
    {
        return array(
            "Content-Type: application/json; charser=UTF-8",
            "X-Line-ChannelID: {$this->conf['channel_id']}",
            "X-Line-ChannelSecret: {$this->conf['channel_secret']}",
            "X-Line-Trusted-User-With-ACL: {$this->conf['mid']}",
        );
    }
}
