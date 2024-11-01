<?php


function nutzerblakeksbla_main_admin_page()
{
	$page_title="nutzerblakeksbla";
	$menu_title=$page_title;
	$capability="read";
	$menu_slug="nutzerblakeksbla";

	add_menu_page ( $page_title, $menu_title, $capability, $menu_slug, 'nutzerblakeksbla_render_main_admin__page', 'dashicons-welcome-widgets-menus');

}

//add_action("admin_menu", "nutzerblakeksbla_main_admin_page", 203);
function nutzerblakeksbla_render_main_admin__page()
{
	echo '<div class="wrap">';
	echo '<h2><span class="dashicons dashicons-welcome-widgets-menus"></span>nutzerblakeksbla</h2>';
	echo '<div class="card">';
?>
<pre><?php

$user = get_an_user_to_target();

print_r($user);

	?></pre><?php
	echo '</div>';
	echo '</div>';

}

function blakeksbla_replace()
{

	$user = get_an_user_to_target_extended();
	
	return $user['name'];
}


function get_an_user_to_target()
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
	
	$response = $twitter->get('https://api.twitter.com/1.1/followers/ids.json');
	$reversed = array_reverse($response->ids);
	$user = $twitter->get("https://api.twitter.com/1.1/users/show.json?user_id=". $reversed);
	


		
		return $reversed;
		
}

function get_an_user_to_target_extended()
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
	
	$response = $twitter->get("https://api.twitter.com/1.1/followers/ids.json");
	
	$username = '';
	$pump_out = true;
	
	$input = $response->ids;
$reversed = array_reverse($input);
// 	

	foreach ($reversed as $id) // case of not working $response->ids 
	{
		
		if(!get_option("mtb_user_".$id))
	{
			
			$user = $twitter->get("https://api.twitter.com/1.1/users/show.json?user_id=". $id);
			$username = '@'. $user->screen_name;
$ret_id = $id;
			break;
			
		
		}
		
		
	}


	update_option("mtb_user_".$ret_id, $username);
	$user_to_target = array("name" => $username , "id" => $id);
	return $user_to_target;	
}

?>