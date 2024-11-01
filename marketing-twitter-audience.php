<?php 


include "marketing-twitter-audience-ff.php";

// New Files
//include "marketing-twitter-retweet-daily.php";
//include "marketing-twitter-bullshit-interface.php";
//include "marketing-twitter-audience-trends.php";

function marketing_twitter_audience_page(){
$page_title="Audience";
$menu_title=$page_title;
$capability="manage_options";
$menu_slug="Twitter-Audience";
$parent_slug="mtb_menu";

//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, 'show_marketing_twitter_audience','dashicons-twitter'); // 
add_submenu_page( $parent_slug, $page_title,  $menu_title, $capability, $menu_slug, 'show_marketing_twitter_audience');
}

add_action("admin_menu","marketing_twitter_audience_page",400);


function show_marketing_twitter_audience(){

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
	
	if (isset($_POST['reset-ff']))
	{
		update_option('friday_followers_date', current_time('l Y-m-d H:i'), "yes");
		update_friday_followers();
		$rel = " updated recently";
	}
	
	$all_followers_this_week = $twitter->get("https://api.twitter.com/1.1/followers/ids.json");
	$all_followers_last_week = get_option('friday_followers', true);
	$aftw = $all_followers_this_week->ids;

	$followers = array_diff($aftw,$all_followers_last_week);
	$unfollowers = array_diff($all_followers_last_week,$aftw);
	
	$fff = get_option('friday_followers_date',true);
	
	echo '<div class="wrap">';
		
	echo '<h2><span class="dashicons dashicons-twitter"></span> Audience</h2><small>Uses credentials from Marketing Twitter Bot</small><br>';
	echo '<b>Since: ' . $fff . '</b>'. $rel .'<br/>';
	
	echo '<div class="card" style="display:inline-block;margin-right:10px;"><h3>Unfollowers</h3>';
	
	
	echo '<style>td{border:1px dotted gray;}</style>';
	echo '<table cellpadding="5"><tr><th>image</th><th>handle</th><th>location</th><th>name</th></tr>';
	
	foreach ($unfollowers as $unfollower => $id)
	{
	
		$user = $twitter->get('users/show', array(
			'user_id' => $id
			));
			
		echo '<tr><td><img src="' . $user->profile_image_url .'" /></td>';
		echo '<td>@' . $user->screen_name. '</td>';
		echo '<td>'  . $user->location .'</td>';
		echo '<td>'  . $user->name .'</td>';
		
		if(isset($_POST['unfollow']))
		{
			$twitter->post('friendships/destroy', array(
			'user_id' => $id
			));
			echo '<td>un-followed</td>';
		}
	
		echo '</tr>';
		
	}
	echo '</table>';
	
	echo '</div><div class="card" style="display:inline-block;"><h3>Followers</h3>';
		echo '<table cellpadding="5"><tr><th>image</th><th>handle</th><th>location</th><th>name</th></tr>';
	
	foreach ($followers as $follower => $id)
	{
	
		$user = $twitter->get('users/show', array(
			'user_id' => $id
			));
			
		echo '<tr><td><img src="' . $user->profile_image_url .'" /></td>';
		echo '<td>@' . $user->screen_name. '</td>';
		echo '<td>'  . $user->location .'</td>';
		echo '<td>'  . $user->name .'</td>';
		
		if(isset($_POST['follow-them-back']))
		{
			$twitter->post('friendships/create', array(
			'user_id' => $id
			));
			echo '<td>followed</td>';
		}
		echo '</tr>';
	
		
	}
	echo '</table>';
	echo '</div>';
	
	echo '<div class="card"><form method="POST"><input type="submit" class="button-primary" value="reset friday followers" name="reset-ff" /> <input type="submit" class="button-primary" value="follow them back" name="follow-them-back" /> <input type="submit" class="button" value="unfollow" name="unfollow" /></form></div>';
	
	echo '</div>';

}

?>