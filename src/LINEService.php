<?php

class LINEService
{
    const TRIAL_API_URL = 'https://trialbot-api.line.me/v1/';

    /**
     * @see https://developers.line.me/bot-api/api-reference
     */
    const TO_CHANNEL_SEND_MSG = '1383378250';
    const EVENT_TYPE_SEND_MSG = '138311608800106203';

    protected $conf = null;

    public function __construct()
    {
        $this->read_conf();
    }

    public function receive_message()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data['result'][0];
    }

    public function post_message($data, $message)
    {
        $header = $this->create_header();
        $curl = new Curl(self::TRIAL_API_URL.'/events');
        $body = json_encode(array(
            'to'        => array($data['content']['from']), // メッセージをくれた人に返す
            'toChannel' => self::TO_CHANNEL_SEND_MSG,
            'eventType' => self::EVENT_TYPE_SEND_MSG,
            'content'   => array(
                'contentType' => 1,
                'toType'      => 1,
                'text'        => $message,
            ),

        ));
        $result = $curl->post($body, $header);
        $error = $curl->get_error();

        return array(
            'Result' => $result,
            'Error'  => $error,
        );
    }

    public function post_image($data, $image_url)
    {
        $header = $this->create_header();
        $curl = new Curl(self::TRIAL_API_URL.'/events');
        $body = json_encode(array(
            'to'        => array($data['content']['from']), // メッセージをくれた人に返す
            'toChannel' => self::TO_CHANNEL_SEND_MSG,
            'eventType' => self::EVENT_TYPE_SEND_MSG,
            'content'   => array(
                'contentType' => 2,
                'toType'      => 1,
                'originalContentUrl' => $image_url,
                'previewImageUrl'    => $image_url,
            ),

        ));
        $result = $curl->post($body, $header);
        $error = $curl->get_error();

        return array(
            'Result' => $result,
            'Error'  => $error,
        );
    }

    public function create_message($data)
    {
        $message = 'ウホウホ';
        $hour = date('H');
        switch ($hour) {
        case 0:
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
            $message = 'zzz...';
            break;
        case 7:
        case 8:
        case 9:
        case 10:
            $message = 'おはよう！';
            break;
        case 11:
        case 12:
            $message = '飯だ飯だ飯だーーーー！！！！';
            break;
        case 13:
            $message = '昼寝かな';
            break;
        case 14:
        case 15:
        case 16:
        case 17:
            $message = 'こんにちは！';
            break;
        case 18:
        case 19:
        case 20:
        case 21:
        case 22:
            $message = 'こんばんは！';
            break;
        case 23:
        case 24:
            $message = 'おはよう！';
            break;
        default:
            break;
        }

        return $message;
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

    protected function read_conf()
    {
        $this->conf = @parse_ini_file(__DIR__.'/setting.ini', true);
    }
}
