<?php 

add_action("mtb_the_scheduled_tweet","mtb_the_scheduled_tweet_tweet_it_now");

function mtb_the_scheduled_tweet_tweet_it_now(){

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
	
	
	
	
	$mtp_scheduled_tweets = get_option("mtp_scheduled_tweets",true);


	if(array_key_exists(0 , $mtp_scheduled_tweets))
	{

		// preperations for the bla keks bla
		
		$tweet =  $mtp_scheduled_tweets[0];
		
		$fake = get_option('twitter_mtb_fake_handle', true);
		//$fake = '@blakeksbla';
		if(strpos($tweet, $fake) !== FALSE)
		{
			$nutzerblakeksbla = blakeksbla_replace();
			$tweet = str_replace($fake, $nutzerblakeksbla, $tweet);
		}
		else
		{
			$tweet=$tweet;
		}

 		$timeline = $twitter->post("statuses/update", array("status" => $tweet));
 		
 		array_shift($mtp_scheduled_tweets);
 		
 		update_option("mtp_scheduled_tweets", $mtp_scheduled_tweets);
	}	
}

include("blakeksbla.php");

?>