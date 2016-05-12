<?php

error_log(">>> hoge");
require_once __DIR__.'/bootstrap.php';

$bot = new Bot();
$bot->execute();
