<?php /*
Plugin Name: WordPress Twitter Bot
Version: 1.11
Description: A plugin to have automatic Twitter on WordPress
Author: wp-plugin-dev.com
Author URI: http://www.wp-plugin-dev.com
*/




include("marketing-twitter-bot-admin-page.php");
include("external.php");

add_action("publish_post", "fire_mtb_marketing_twitter_bot_with_post");

?>