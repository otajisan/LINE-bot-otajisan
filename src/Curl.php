<?php

class Curl
{
    protected $handle = null;

    protected $options = array(
        CURLOPT_RETURNTRANSFER => true,
    );

    public function __construct($url = '')
    {
        $this->init($url);
    }

    public function init($url)
    {
        $this->handle = curl_init($url);
    }

    public function set_options($options)
    {
        foreach ($options as $key => $val) {
            $this->options[$key] = $val;
        }
    }

    public function get($url)
    {
        $this->init($url);
        curl_setopt_array($this->handle, $this->options);
        return curl_exec($this->handle);
    }

    public function post($body, $header = array())
    {
        $this->set_options(array(
            CURLOPT_POST       => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $body,
        ));
        curl_setopt_array($this->handle, $this->options);

        return curl_exec($this->handle);
    }

    public function get_error()
    {
        return array(
            'No'    => curl_errno($this->handle),
            'Error' => curl_error($this->handle),
        );
    }

    public function close()
    {
        curl_close($this->handle);
    }

    public function __destruct()
    {
        $this->close();
    }
}
