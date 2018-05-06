<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/dbConnect.php';
require_once __DIR__.'/../app/Wellstreet/functions/functions.php';

/*-----------TWIG---------------*/
$loader = new Twig_Loader_Filesystem(__DIR__ . '/../public_html/templates/');
$twig = new Twig_Environment($loader, array(
//    'cache' => '',//todo set a cache folder in production to optimize
    'debug'=>'false'//set to true in development
));
$twig->addExtension(new \Wellstreet\classes\UcWordsExtension());

/*--------SWIFTMAILER--------*/
// Create the Transport
$transport = (new Swift_SmtpTransport('mail.wellstreetapp.co.uk', 25))
    ->setUsername('jens@wellstreetapp.co.uk')
    ->setPassword('$Password01')
;
// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

//mail messages
$newUsersMessage = (new Swift_Message('New Users for well-street-app'))
    ->setFrom(['admin@wellstreetapp.co.uk' => 'Admin'])
;