<?php

class Curl
{
    protected $handle = null;

    protected $options = array(
        CURLOPT_RETURNTRANSFER => true,
    );

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->handle = curl_init();
    }

    public function set_options($options)
    {
        foreach ($options as $key => $val) {
            $this->options[$key] = $val;
        }
    }

    public function post($header, $body)
    {
        $this->set_options(array(
            CURLOPT_POST       => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $body,
        ));
        curl_setopt_array($this->handle, $this->options);

        $result = curl_exec($this->handle);

        $this->close();
    }

    public function close()
    {
        curl_close($this->handle);
    }
}
