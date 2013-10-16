<?php

require_once 'twitteroauth/twitteroauth.php';

$json = file_get_contents('http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=8&q=http%3A%2F%2Fnews.google.com%2Fnews%3Foutput%3Drss');

die (print_r($json, true));
$obj = json_decode($json);

$rnd = rand(5, 20);

$artical = $obj->responseData->feed->entries[$rnd];


$url = $artical->link;
$shortUrl = file_get_Contents('http://tinyurl.com/api-create.php?url=' . $url);

if (strlen($artical->title . " " . $shortUrl) >= 140) {
    $size = strlen($artical->title . " " . $shortUrl);
    $diff = $size - 140;
    $postContent = substr($artical->title, 0, strlen($artical->title) - $diff-5);
    $postContent .= "..."; 
    
} else {
    $postContent =  $artical->title;
}

$words = explode(" ", $postContent);

$file_handle = fopen("91Knouns.txt", "r");
$done = false;

while (!feof($file_handle) || !$done) {
    $line = trim(fgets($file_handle));
    for ($i = 0; $i < sizeof($words); $i++) {
        if (strcasecmp($words[$i], $line) == 0 && !$done) {
            $words[$i] = "#" . $words[$i];
            $postContent = implode(" ", $words);
            $done = true;
            break;
        }
    }
    
}

fclose($file_handle);

$out =  trim($postContent . " " . $shortUrl);

die ($out);

define('CONSUMER_KEY', 'your CONSUMER_KEY');
define('CONSUMER_SECRET', 'your CONSUMER_SECRET');
define('OAUTH_TOKEN', 'your OAUTH_TOKEN');
define('OAUTH_SECRET', 'your OAUTH_SECRET');
 
 
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);


$content = $connection->get('account/verify_credentials');


$connection->post('statuses/update', array('status' => $out));


?>
