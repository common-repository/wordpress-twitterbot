<?php 

function marketing_twitter_scheduled_tweets_page(){
$page_title=__("Scheduled Tweets","mtb");
$menu_title=$page_title;
$capability="manage_options";
$menu_slug="Twitter-Scheduled-Tweets";
$parent_slug="mtb_menu";

//add_menu_page ( $page_title, $menu_title, $capability, $menu_slug, 'show_marketing_twitter_scheduled_tweets_functions','dashicons-twitter');
add_submenu_page( $parent_slug, $page_title,  $menu_title, $capability, $menu_slug, 'show_marketing_twitter_scheduled_tweets_functions');

}

add_action("admin_menu","marketing_twitter_scheduled_tweets_page",402);


function show_marketing_twitter_scheduled_tweets_functions(){
	
	
	if(isset($_POST['time-line-tray-save'])){
	
		$scheduled_tweet = $_POST["scheduled-tweet"];
		update_option("mtp_scheduled_tweets", $scheduled_tweet);
		
		if($_POST['bulk-insert-tweets']!="")
		{
			$bulk_array = explode("\n",$_POST['bulk-insert-tweets']);
			
			$tweet_array = array_merge($scheduled_tweet,$bulk_array);
			update_option("mtp_scheduled_tweets", $tweet_array);
		}
		
	}

	echo '<div class="wrap">';
	
	echo '<form class="mtb_form" method="POST">';
		
	// echo '<div class="card">Debug:<br>';
// 		$times = implode(";", $_POST['scheduled-tweet']);
// 		print_r($_POST['scheduled-tweet']);
// 		echo "<hR>";
// 		print_r(get_option("mtp_scheduled_tweets",true));
// 	echo '</div>';	
		
	echo '<h2><span class="dashicons dashicons-twitter"></span> Scheduled Tweets</h2>';
	

	echo '<div class="card">';

		$mtp_timeline_tray = get_option("mtp_timeline_tray",true);
	sort($mtp_timeline_tray);
	
	$now = current_time("timestamp");

	$weekday = date( 'l', $now);
	

	
	$first_key = false;
	//echo $now."<br>";
	foreach ($mtp_timeline_tray as $key => $value)
	{
	
	
		$value = strtotime($value);
// 				print_r($key);
// 				echo " ";
// 				print_r($value);
// 				echo "<br>";
		if($value > $now && $first_key == false)
		{
			$i = $key;
			$first_key = true;
			
		}
	}
	
	$mtp_count = count($mtp_timeline_tray);
	
	

	echo __("Add a tweet or remove by clicking the buttons","mtb");
	echo ' <a href="#"  style="text-decoration:none;"  class="plus"><span class="dashicons dashicons-plus-alt"></span></a> </div><div class="card tweet-timeline-tray">';
	

	$mtp_scheduled_tweets = get_option("mtp_scheduled_tweets",true);
	
	//$i = 0;

	foreach ($mtp_scheduled_tweets as $element)
	{
		// this is the master line
		echo '<div class="stweet"><a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a><br><textarea style="display:inline-block;" maxlength="280" class="scheduled-tweet" name="scheduled-tweet[]">'.$element.'</textarea><div class="time" style="padding:5px;display:inline-block;color:lightgray;font-weight:bold;"> </div></div>';
		$i++;
		if($i ==  $mtp_count)
		{ 
			$i=0;
			
			$weekday = date( 'l', strtotime($mtp_timeline_tray[$i])+86400) ;	
		}
	}
	

	echo '</div>';
	
	echo '<div class="card"><input type="submit" name="time-line-tray-save" class="button-primary" />';

	
	echo '</div>';
	

		
	
	echo '<script>
		

			
			jQuery( ".plus" ).on("click", function(){
					jQuery(".tweet-timeline-tray").delegate().append(\'<div class="stweet"><a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a><br><textarea maxlength="240" class="scheduled-tweet" name="scheduled-tweet[]"></textarea></div>\');
			});
	
	
			jQuery( ".minus" ).live("click", function() {
	  				jQuery(this).parent(".stweet").remove();
	  			
			});	

			
		
		

		</script>';	
		
	//echo '</div>';

	echo '<div class="card">';

	echo '<h3>Bulk Insert</h3>';
	echo '<textarea name="bulk-insert-tweets"></textarea>';

	echo '</div>';
	
	echo '</form>';
	
	echo '</div>';//wrap

}

?>