<?php

require_once __DIR__ . 'vendor/autoload.php';

//load env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if(!$_ENV['QUEUE_SQS_URL'] || !$_ENV['ASW_KEY'] || !$_ENV['AWS_SECRET']){
    throw new \Exception('Configure o .env');
}