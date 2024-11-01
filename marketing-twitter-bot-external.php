<?php
// new Version 1.0

function get_twitter_followers_internal($twitter)
{
	$tweets = $twitter->get("https://api.twitter.com/1.1/followers/list.json?cursor=-1&count=5");
	$screen_names = "";
	foreach ($tweets as $tweet)
	{
		foreach ($tweet as $bu)
		{
			$screen_names .= "@".$bu->screen_name.", ";

		}
	}
	return $screen_names;
}

function fire_mtb_marketing_twitter_bot()
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
	$my_tweet = twitter_message_on_mtb();
	$twitter->host = "https://api.twitter.com/1.1/";

	$mtb_bullshit_gword = get_option("general_bs_word", true);
	if (strpos($my_tweet, $mtb_bullshit_gword) !== false)
	{
		// experimental mode
		// todo use this internally
		// todo on/off interface for this
		$timestamp = time();

		$this_friday= date('Y-m-d', $timestamp);

		$friday = get_option("ff_date_txt", false);

		$dw = date("w", $timestamp);
		if ($dw == 5 && ($friday != $this_friday))
		{
			$last_followers = rtrim(get_twitter_followers_internal($twitter), ',');
			$return_tweet = "Thank you " . $last_followers ." and a happy Weekend! #ff #followfriday";
			$rtv = $twitter->post('statuses/update', array(
					'status' => $return_tweet
				));
			$new_file = update_option("ff_date_txt", $this_friday);
		}
		else
		{
			$bs = bg_tweet_make_bullshit();
			$rtv = $twitter->post('statuses/update', array(
					'status' => $bs
				));

		}
	}
	else if ($my_tweet == "" && get_option("follow_friday_tweet", false) == "on")
		{
			// experimental mode
			$timestamp = time();

			$this_friday= date('Y-m-d', $timestamp);

			$friday = get_option("ff_date_txt", false);

			$dw = date("w", $timestamp);
			if ($dw == 5 && ($friday != $this_friday))
			{
				$last_followers = rtrim(get_twitter_followers_internal($twitter), ',');
				$return_tweet = "Thank you " . $last_followers ." and a happy Weekend! #ff #followfriday";
				$rtv = $twitter->post('statuses/update', array(
						'status' => $return_tweet
					));
				$new_file = update_option("ff_date_txt", $this_friday);
			}
			else
			{
				// dont post bullshit if not intended
			}
		}
	else
	{
		$rtv = $twitter->post('statuses/update', array(
				'status' => $my_tweet
			));

		// print_r($rtv);
	}
}

function fire_mtb_marketing_twitter_bot_with_post($post_id)
{
	if (($_POST['post_status'] == 'publish') && ($_POST['original_post_status'] != 'publish'))
	{
		$post = get_post($post_id);
		$tweet = substr($post->post_title, 0, 116);
		$url = get_permalink($post_id);
		$tweet = $tweet . " " . $url;
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
		$my_tweet = $tweet;
		$twitter->host = "https://api.twitter.com/1.1/";
		if ($my_tweet == "")
		{
		}
		else
		{
			$rtv = $twitter->post('statuses/update', array(
					'status' => $my_tweet
				));

			// print_r($rtv);
		}
	}
	else
	{
	}
}

function bg_tweet_make_bullshit()
{
	$header_banner_verb_one = get_option("header_banner_verb_one", true);
	$header_banner_verb_two = get_option("header_banner_verb_two", true);
	$header_banner_noun = get_option("header_banner_noun", true);
	$header_banner_fill = get_option("header_banner_fill", true);

	$tweet_sentence_begin = get_option("tweet_sentence_begin", true);
	$tweet_sentence_end = get_option("tweet_sentence_end", true);

	$the_string = $tweet_sentence_begin[array_rand($tweet_sentence_begin)] .' '. $header_banner_verb_one[array_rand($header_banner_verb_one) ] . ' ' . $header_banner_verb_two[array_rand($header_banner_verb_two) ] . ' ' . $header_banner_noun[array_rand($header_banner_noun) ] . ' ' . $header_banner_fill[array_rand($header_banner_fill) ] .' '. $tweet_sentence_end[array_rand($tweet_sentence_end)];
	return $the_string;
}

?>