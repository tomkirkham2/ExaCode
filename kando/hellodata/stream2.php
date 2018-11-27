<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
//generate random number for demonstration
$client = new Mosquitto\Client();
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');
$client->connect("localhost", 1883, 5);
$client->subscribe('/#', 1);

while (true) {
$client->loop();
$new_data = rand(0, 1000);
//echo the new number
echo "data: New random number: {$new_data}\n\n";
flush();
$client->loop();
sleep(2);

}

$client->disconnect();
unset($client);

function connect($r) {
        echo "I got code {$r}\n";
}


function subscribe() {
        echo "Subscribed to a topic\n";
}

function message($message) {
echo "data: New Reading {$message->payload}\n\n";

//      printf("Got a message which has a ID %d on topic %s with payload:\n%s\n\n", $message->mid, $message->topic, $message->payload);
flush();
}

function disconnect() {
        echo "Disconnected cleanly\n";
}


?>
