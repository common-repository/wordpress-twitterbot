<?php

include "marketing-twitter-rand-post.php";

function marketing_twitter_audience_trends_page()
{
	$page_title="Audience Trends";
	$menu_title=$page_title;
	$capability="manage_options";
	$menu_slug="Twitter-Audience-Trends";
	$parent_slug="Twitter-Audience";

	//add_menu_page ( $page_title, $menu_title, $capability, $menu_slug, 'show_marketing_twitter_audience_trends', 'dashicons-hammer');

}

//add_action("admin_menu", "marketing_twitter_audience_trends_page", 203);

function show_marketing_twitter_audience_trends()
{

	echo '<h2><span class="dashicons dashicons-twitter"></span> Home Timeline</h2><small>Uses credentials from Marketing Twitter Bot</small><br>';
	echo '<div class="wrap">';
	echo '<div class="card" style="display:inline-block;margin-right:10px;"><pre>';
	
	
	echo '</pre></div>';

	echo '<div class="card">';
	//echo mtb_show_random_post_tweet();
	echo '</div>';
	echo '</div>';

}

include "marketing-twitter-audience-trends-external.php";

add_action("mtb_audience_trends_scheduled", "mtb_the_current_day_tweet_data");


function the_audience_trends_tweet()
{
	$t = get_option("tweet_data_today", true);

	$hashtags  = $t['hashtags'];
	$text = $t['text'];
	$weekday = $t['weekday'];

	$written_text = write_a_new_sentence(first_words(get_word_frequency($text)), 'yes');

	$written_hashtags = first_words(get_word_frequency($hashtags));

	//print_r($written_text."<br><br>");
	$wsh = first_two_words($written_hashtags);

	foreach ($wsh as $s => $sws)
	{
		$h_st .= '#'.$s.' ';
	}
	return '#'.$weekday.' '.$written_text.' '.$h_st;

}

function marketing_twitter_audience_trends_tweet_process()
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

	$tweet = the_audience_trends_tweet();

	$checked = get_option("audience-trends-check", true);

	if
	($checked == "on")
	{
		$timeline = $twitter->post("statuses/update", array("status" => $tweet));
	}
}

?>