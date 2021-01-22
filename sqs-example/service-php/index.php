<?php
    require_once './vendor/autoload.php';

    //load env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    if(!$_ENV['QUEUE_SQS_URL'] || !$_ENV['ASW_KEY'] || !$_ENV['AWS_SECRET']){
        throw new \Exception('Configure o .env');
    }

    $queueUrl = $_ENV['QUEUE_SQS_URL'];

    $credentials = new \Aws\Credentials\Credentials($_ENV['ASW_KEY'],$_ENV['AWS_SECRET']);

    $awsClient = new \Aws\Sqs\SqsClient([
        'credentials'   => $credentials,
        'region'        => 'sa-east-1',
        'version'       => '2012-11-05'
    ]);

    try {
        $result = $awsClient->receiveMessage([
            'QueueUrl'      => $queueUrl,
        ]);
        $messages = $result->get('Messages');
        if(!empty($messages)){
            foreach ($messages as $i => $message) {
                echo "Order: " . $i . PHP_EOL;
                echo "Body: " . $message['Body'] . PHP_EOL;
                echo "Receipt handle: " . $message['ReceiptHandle'] . PHP_EOL;
                echo "Processamento fake hehehe..." . PHP_EOL;
                echo "Deletando message" . PHP_EOL;
                $awsClient->deleteMessage([
                    'QueueUrl'          => $queueUrl,
                    'ReceiptHandle'     => $message['ReceiptHandle'],
                ]);
                echo "Deletada" . PHP_EOL;
            }
        } else {
            echo "SEM MENSAGEM NA FILA";
        }
    } catch (\Aws\Exception\AwsException $th) {
        print($th);
    }