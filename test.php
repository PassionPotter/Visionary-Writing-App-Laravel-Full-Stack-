
<?php

require_once "vendor/autoload.php"; 
use Twilio\Rest\Client;

ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$sid = "AC4b9f855f31fa4e27384e206a7a89e940"; // Your Account SID from www.twilio.com/console
$token = "f9519c991c2a9a50bf6e9058e541dba4"; // Your Auth Token from www.twilio.com/console

$client = new Twilio\Rest\Client($sid, $token);
$message = $client->messages->create(
  '+1-972-954-9616', // Text this number
  [
    'from' => '+12145096585', // From a valid Twilio number
    'body' => 'Hello from Twilio!'
  ]
);

print $message->sid;
echo "abc";

 ?>