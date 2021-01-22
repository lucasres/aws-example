<?php

require_once __DIR__ . '/vendor/autoload.php';

//load env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if(!$_ENV['LAMBDA_FUNCTION'] || !$_ENV['AWS_KEY'] || !$_ENV['AWS_SECRET']){
    throw new \Exception('Configure o .env');
}
//cria as credenciais
$credentials = new \Aws\Credentials\Credentials($_ENV['AWS_KEY'],$_ENV['AWS_SECRET']);

$lambdaClient = new \Aws\Lambda\LambdaClient([
    'credentials'   => $credentials,
    'region'        => 'us-east-1',
    'version'       => '2015-03-31',
]); 
//corpo da mensagem
$payload = ['a' => 50, 'b' => 100];
try {
    //chamada para aa lambda function
    $result = $lambdaClient->invoke([
        'FunctionName'      => $_ENV['LAMBDA_FUNCTION'],
        'InvocationType'    => 'RequestResponse', //faz uma chamada sincrona,
        'Payload'           => json_encode($payload),
    ]);
    //mostra o resultado
    $response = $result->get('Payload');
    print($response);
} catch (\Aws\Exception\AwsException $th) {
    print($th);
}