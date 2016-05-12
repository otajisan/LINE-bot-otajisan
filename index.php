<?php

require_once __DIR__.'/bootstrap.php';

$service = new LINEService();
$service->receive_message();
