<?php 

function marketing_twitter_own_retweet_process(){

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
	
	$mtb_last_retweet = get_option("last_retweet_mtb",true);
	$mtb_last_retweet = $mtb_last_retweet +1;
	$the_id = get_last_tweet_id_mtb($twitter, $mtb_last_retweet);
	
	update_option("last_retweet_mtb", $the_id);
	$checked = get_option("retweet-daily-check",true);
        if($checked == "on")
        {
 			$timeline = $twitter->post("statuses/retweet", array("id" =>$the_id));
		}
}

function get_last_tweet_id_mtb($twitter, $id){

$last_id = "";

	$timeline = $twitter->get("https://api.twitter.com/1.1/statuses/user_timeline.json?count=200");
	
	$last = end($timeline);
	
	$entries = $timeline[0]->user->statuses_count;
	
	$pages = (int) ($entries / 200);
	
	$i = 0;
	while($i < $pages)
	{
		$timeline = $twitter->get("https://api.twitter.com/1.1/statuses/user_timeline.json?count=200&since_id=".$id."&max_id=".$last->id);
		$last = end($timeline);
		$last_id = $last->id;
		$i++;
	}
	
	return $last_id;
	
}


	
	
	function mtb_create_daily_retweet_schedule(){

  		$timestamp = wp_next_scheduled( 'create_daily_retweet' );

  		if( $timestamp == false ){
    		wp_schedule_event( time(), 'daily', 'create_daily_retweet' );
  		}
	}

	add_action( 'create_daily_retweet', 'marketing_twitter_own_retweet_process' );
	
function mtb_destroy_daily_retweet_schedule()
{
	wp_clear_scheduled_hook( 'create_daily_retweet');
}
?>