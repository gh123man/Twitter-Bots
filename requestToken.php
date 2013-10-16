<?php

require_once './twitteroauth/twitteroauth.php';

$CONSUMER_KEY = "Your CONSUMER KEY";
$CONSUMER_SECRET = "Your CONSUMER SECRET";

define('CONSUMER_KEY', $CONSUMER_KEY);
define('CONSUMER_SECRET', $CONSUMER_SECRET);

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
$request_token = $connection->getRequestToken("");

$token = $request_token['oauth_token'];
$secrete = $request_token['oauth_token_secret'];

switch ($connection->http_code) {
  case 200:
    $url = $connection->getAuthorizeURL($token);
    echo $url . "\n\nenter PIN and press the return key: ";
    
    $f = fopen( 'php://stdin', 'r' );

    $verify = fgets( $f );

    fclose( $f );
    
    $verify = trim($verify);
    
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $token, $secrete);
    
    $access_token = $connection->getAccessToken($verify);
    
    file_put_contents( $access_token['screen_name'] . '.txt', print_r($access_token, true));
    echo $access_token['screen_name'] . '.txt' . " file saved with account codes";

    break;
  default:
    echo 'Could not connect to Twitter.';
}



?>
