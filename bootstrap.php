<?php

spl_autoload_register(function($cls) {
    require_once 'src/'.$cls.'.php';
});
