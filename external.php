<?php


function fire_mtb_marketing_twitter_bot_with_post($post_id){
if( ( $_POST['post_status'] == 'publish' ) && ( $_POST['original_post_status'] != 'publish' ) ) {
$post = get_post($post_id);
$tweet=substr($post->post_title,0,116);
$url = get_permalink($post_id);
$tweet=$tweet." ".$url;
$consumerKey=get_option('twitter_mtb_consumer_key', true);
$consumerSecret=get_option('twitter_mtb_consumer_secret', true);
$accessToken=get_option('twitter_mtb_access_token', true);
$accessTokenSecret=get_option('twitter_mtb_access_token_secret', true);

define('CONSUMER_KEY', $consumerKey);
define('CONSUMER_SECRET', $consumerSecret);
define('ACCESS_TOKEN', $accessToken);
define('ACCESS_TOKEN_SECRET', $accessTokenSecret);

require_once('twitteroauth.php');
$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$my_tweet=$tweet;

$twitter->host = "https://api.twitter.com/1.1/";

if ($my_tweet==""){}
else{
$rtv=$twitter->post('statuses/update', array('status' => $my_tweet));
//print_r($rtv);
}
}else{}

}


 ?>