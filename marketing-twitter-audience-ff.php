<?php

function update_friday_followers()
{
	$consumerKey = get_option('twitter_mtb_consumer_key', true);
	$consumerSecret = get_option('twitter_mtb_consumer_secret', true);
	$accessToken = get_option('twitter_mtb_access_token', true);
	$accessTokenSecret = get_option('twitter_mtb_access_token_secret', true);
	define('CONSUMER_KEY', $consumerKey);
	define('CONSUMER_SECRET', $consumerSecret);
	define('ACCESS_TOKEN', $accessToken);
	define('ACCESS_TOKEN_SECRET', $accessTokenSecret);
	require_once ('twitteroauth.php');

	$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	$twitter->host = "https://api.twitter.com/1.1/";

	$all_followers_this_week = $twitter->get("https://api.twitter.com/1.1/followers/ids.json");
	$aftw = $all_followers_this_week->ids;
	update_option('friday_followers',$aftw);
}

?>