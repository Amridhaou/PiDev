<?php
use Twilio\Rest\Client;

$sid = 'AC5374fded803f7e73cdbfbf67815909bb';
$token = 'e260dd1d358c69dd1ec176aeaad1ca98';
$client = new Client($sid, $token);

$client->messages->create(
// the number you'd like to send the message to
    '+21620975160',
    [
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+15746269419',
        // the body of the text message you'd like to send
        'body' => 'aa habib wselt wala ma wseltch ?'
    ]
);
if (file_exists(dirname(__DIR__).'/var/cache/prod/App_KernelProdContainer.preload.php')) {
    require dirname(__DIR__).'/var/cache/prod/App_KernelProdContainer.preload.php';
}
