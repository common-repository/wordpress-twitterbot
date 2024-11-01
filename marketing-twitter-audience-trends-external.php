<?php

include("devriant-semantics-functions.php");


add_action( 'content_tweet_mtb', 'marketing_twitter_own_content_tweet_process' );
add_action( 'audience_tweet_trends', 'mtb_the_current_day_tweet_data' );


function mtb_the_current_day_tweet_data()
{
	
	$consumerKey = get_option('twitter_mtb_consumer_key', true);
	$consumerSecret = get_option('twitter_mtb_consumer_secret', true);
	$accessToken = get_option('twitter_mtb_access_token', true);
	$accessTokenSecret = get_option('twitter_mtb_access_token_secret', true);
	define('CONSUMER_KEY', $consumerKey);
	define('CONSUMER_SECRET', $consumerSecret);
	define('ACCESS_TOKEN', $accessToken);
	define('ACCESS_TOKEN_SECRET', $accessTokenSecret);
	require_once 'twitteroauth.php';

	$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
	$twitter->host = "https://api.twitter.com/1.1/";
	$timeline = $twitter->get('statuses/home_timeline', array('count' => 5));

	
	$tweet_data_today = get_option("tweet_data_today",true);
	
	//print_r($tweet_data_today);
	
	$old_hashtags = $tweet_data_today["hashtags"];
	$old_text = $tweet_data_today["text"];
	$old_weekday = $tweet_data_today["weekday"];
	
	$hashtags = array();
	
	foreach ($timeline as $line)
	{
		$text = $line->text;
		//$text = str_replace("plugins","",$text);
		$text = str_replace("https://t.co/","",$text);



		foreach ($line->entities->hashtags as $tag)
		{
			array_push($hashtags, $tag->text);
		}
			
	}

	$text = $old_text .' '. $text;

	$hashtags_string = implode(",",$hashtags);
	
	$hashtags =  $old_hashtags .",".$hashtags_string ;
	
	$currentday = date('l');
	
	if($currentday == $old_weekday)
	{
		update_option("tweet_data_today", array( "hashtags" => $hashtags, "text" => $text, "weekday" => $currentday));	
	}
	else
	{
		marketing_twitter_audience_trends_tweet_process();
		$currentday_after_tweet = date('l');
		delete_option("tweet_data_today");
		update_option("tweet_data_today", array( "hashtags" => "", "text" => "", "weekday" => $currentday_after_tweet));
	}
}

?>
