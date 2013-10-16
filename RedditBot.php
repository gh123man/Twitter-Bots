<?php

require_once 'twitteroauth/twitteroauth.php';

$json = file_get_contents('http://www.reddit.com/r/mildlyinteresting.json');

$obj = json_decode($json);

$rnd = rand(0, 23);

$topPost = $obj->data->children[$rnd]->data;


$url = $topPost->url;
$shortUrl = file_get_Contents('http://tinyurl.com/api-create.php?url=' . $url);

if (strlen($topPost->title . " " . $shortUrl) >= 140) {
    $size = strlen($topPost->title . " " . $shortUrl);
    $diff = $size - 140;
    $postContent = substr($topPost->title, 0, strlen($topPost->title) - $diff-5);
    $postContent .= "..."; 
    
} else {
    $postContent =  $topPost->title;
}

$words = explode(" ", $postContent);

$file_handle = fopen("91Knouns.txt", "r");
$done = false;
while (!feof($file_handle)) {
    $line = trim(fgets($file_handle));
    for ($i = 0; $i < sizeof($words); $i++) {
        if ($words[$i] == $line && !$done) {
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

