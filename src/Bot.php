<?php

class Bot
{
    const BIJO_RSS_URL = 'https://ajax.googleapis.com/ajax/services/feed/load?v=1.0&q=http://feedblog.ameba.jp/rss/ameblo/ryo640/rss20.xml&num=10';

    public function execute()
    {
        $bijo = $this->get_bijo();
        $service = new LINEService();
        $data = $service->receive_message();
        $message = $service->create_message($data, $bijo);
        $service->post_message($data, $message);
        $service->post_image($data, $bijo);
    }

    protected function get_bijo()
    {
        $curl = new Curl();
        $result = $curl->get(self::BIJO_RSS_URL);
        preg_match_all('/img src">/', $result, $matches);
        //        error_log(print_r($matches, 1));
        $result = json_decode($result, true);
        $entries = $result['responseData']['feed']['entries'];

        $contents = array();
        $images = array();
        foreach ($entries as $entry) {
            $contents[] = $entry['content'];
            preg_match('/src="(.*?)"/', $entry['content'], $img);
            $images[] = $img[1];
        }

        $rand = intval(mt_rand(0, count($images) - 1));

        return $images[$rand];
    }
}
