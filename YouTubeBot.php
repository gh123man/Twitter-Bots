<?php

require_once 'twitteroauth/twitteroauth.php';

$json = file_get_contents('http://gdata.youtube.com/feeds/api/standardfeeds/top_rated?time=today&alt=json');

$obj = json_decode($json);


$rnd = rand(0, 23);
$title = '$t';
$video = $obj->feed->entry[$rnd];
$title = $video->title->$title;
$url = $video->link[0]->href;


$shortUrl = file_get_Contents('http://tinyurl.com/api-create.php?url=' . $url);

if (strlen($title . " " . $shortUrl) >= 140) {
    $size = strlen($title . " " . $shortUrl);
    $diff = $size - 140;
    $postContent = substr($title, 0, strlen($title) - $diff-5);
    $postContent .= "..."; 
    
} else {
    $postContent =  $title;
}

$words = explode(" ", $postContent);

$file_handle = fopen("91Knouns.txt", "r");
$done = false;
while (!feof($file_handle)) {
    $line = trim(fgets($file_handle));
    for ($i = 0; $i < sizeof($words); $i++) {
        if (strcasecmp($words[$i], $line) == 0 && !$done) {
            $words[$i] = "#" . $words[$i];
            $postContent = implode(" ", $words);
            $done = true;
        }
    }
}

fclose($file_handle);

$out =  trim($postContent . " " . $shortUrl);

define('CONSUMER_KEY', 'your CONSUMER_KEY');
define('CONSUMER_SECRET', 'your CONSUMER_SECRET');
define('OAUTH_TOKEN', 'your OAUTH_TOKEN');
define('OAUTH_SECRET', 'your OAUTH_SECRET');
 
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);


$content = $connection->get('account/verify_credentials');


$connection->post('statuses/update', array('status' => $out));


?>
