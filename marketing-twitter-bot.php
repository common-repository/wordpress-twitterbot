<?php /*
Plugin Name: Marketing Twitter Bot [deprecated functions]
Version: 1.3
Description: A plugin to have automatic Twitter with WordPress
Author: emojized
*/


// Performance Change ... uncomment if than else here
// and in msg the comments

include("marketing-twitter-bot-msg.php");
//include("marketing-twitter-bot-legacy-page.php");
include("marketing-twitter-bot-external.php");
include("marketing-twitter-bot-credentials.php");
include("marketing-twitter-time-functions.php");
include("marketing-twitter-audience.php");
include("marketing-twitter-scheduled-tweets.php");
include("marketing-twitter-retweet-daily.php");
//include("marketing-twitter-bullshit-interface.php");
include("marketing-twitter-telegram-bridge.php");
include("marketing-twitter-audience-trends.php");
//include("retweet.php");

//register_activation_hook( __FILE__, 'mtb_create_daily_retweet_schedule' );
//register_deactivation_hook( __FILE__, 'mtb_destroy_daily_retweet_schedule' );


// $mtb_views=(int) get_option("mtb_views", true);
// $mtb_interval=(int) get_option("mtb_interval", true);
// 
// 
// 
// //changed
// if(($mtb_views % $mtb_interval)==0 ){
// $mtb_views++;
// update_option("mtb_views",$mtb_views);
// //add_action("init","fire_mtb_marketing_twitter_bot");
// 
// }else{
// $mtb_views++;
// update_option("mtb_views",$mtb_views);
// 
// 
// }

//add_action("publish_post", "fire_mtb_marketing_twitter_bot_with_post");

// if(($mtb_views % $mtb_retweet_interval)==0 ){
// $mtb_views++;
// update_option("mtb_views",$mtb_views);
//add_action("init","fire_mtb_retweet_marketing_twitter_bot");
// }else{
// $mtb_views++;
// update_option("mtb_views",$mtb_views);}


function start_the_telecron()
{
	if ( ! wp_next_scheduled( 'telecronter' ) ) {
	  wp_schedule_event( time(), 'tenminutes', 'telecronter' );
	}
}

//add_action("init","start_the_friday");


function start_the_friday()
 {
if ( ! wp_next_scheduled( 'fire_mtb_marketing_twitter_bot' ) ) {
 	  wp_schedule_event( 1497615300, 'weekly', 'nagel' );
 	}
}

add_action("nagel","fire_mtb_marketing_twitter_bot");

function add_weekly_cron_schedule( $schedules ) {
    $schedules[ 'weekly' ] = array( 
        'interval' => 604800,
        'display' => 'weekly' );
    return $schedules;
}
add_filter( 'cron_schedules', 'add_weekly_cron_schedule' );
// 
// //new to get telegram messages but has to be activation hook
// // and deactivatio nhook
// 
//add_action("init","start_the_friday");

add_action("telecronter","the_ttt_process");


?>