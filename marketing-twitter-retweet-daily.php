<?php
function marketing_twitter_own_retweet_page()
{
	$page_title="Special Tweets";
	$menu_title=$page_title;
	$capability="manage_options";
	$menu_slug="Twitter-Own-Retweet";
	$parent_slug="mtb_menu";

	//add_menu_page ( $page_title, $menu_title, $capability, $menu_slug, 'show_marketing_twitter_own_retweet','dashicons-twitter');
	add_submenu_page( $parent_slug, $page_title,  $menu_title, $capability, $menu_slug, 'show_marketing_twitter_own_retweet');

}

add_action("admin_menu", "marketing_twitter_own_retweet_page", 404);

include "marketing-twitter-retweet-daily-external.php";
include "marketing-twitter-tweet-content.php";

function show_marketing_twitter_own_retweet()
{

	if
	(isset($_POST['check-retweet']))
	{
		update_option("retweet-daily-check", $_POST['onoffswitch']);
		update_option("post-content-check", $_POST['onoffswitch1']);
		update_option("audience-trends-check", $_POST['onoffswitch2']);
		update_option("follow_friday_tweet", $_POST['onoffswitch3']);

		if
		($_POST['onoffswitch1']=="on")
		{
			if ( ! wp_next_scheduled( 'content_tweet_mtb' ) )
			{
				wp_schedule_event( time(), 'quarterday', 'content_tweet_mtb' );
			}
		}
		else
		{
			wp_clear_scheduled_hook( 'content_tweet_mtb' );
		}
		if
		($_POST['onoffswitch2']=="on")
		{
			if ( ! wp_next_scheduled( 'audience_tweet_trends' ) )
			{
				wp_schedule_event( time(), 'tenminutes', 'audience_tweet_trends' );
			}
		}
		else
		{
			wp_clear_scheduled_hook( 'audience_tweet_trends' );
		}


	}
	echo '<div class="wrap">';
	echo '<h2><span class="dashicons dashicons-twitter"></span>Special Tweets</h2><small>Uses credentials from Marketing Twitter Bot</small><br>';

	echo '<div class="card"><form method="POST">';

	echo '<label> Retweet myself daily </label><br><br>
	      <div class="onoffswitch">
        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" ';

	$checked = get_option("retweet-daily-check", true);
	if
	($checked == "on")
	{
		echo "checked";
	}
	echo '>
        <label class="onoffswitch-label" for="myonoffswitch">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </div><br><br><label> Tweet post content </label><br><br>
	';

	echo '
        <input type="checkbox" name="onoffswitch1" ';

	$checked = get_option("post-content-check", true);
	if
	($checked == "on")
	{
		echo "checked";
	}
	echo '  style="transform:scale(3, 3);" ><br><br>
	';

	echo '<label> Audience trends </label><br><br>
        <input type="checkbox" name="onoffswitch2" ';

	$checked = get_option("audience-trends-check", true);
	if
	($checked == "on")
	{
		echo "checked";
	}
	echo '  style="transform:scale(3, 3);" ><br><br>
	';
	
	
	echo '<label> Follow Friday tweets</label><br><br>
			<input type="checkbox" name="onoffswitch3" ';
	
	$checked = get_option("follow_friday_tweet", true);
	if
	($checked == "on")
	{
		echo "checked";
	}
	echo '  style="transform:scale(3, 3);" ><br><br>
	';

	echo '<input type="submit" class="button-primary" name="check-retweet" />';
	echo '</form></div>';

	echo '<style>
		       .onoffswitch {
        position: relative; width: 90px;
        -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    }
    .onoffswitch-checkbox {
        display: none !important;
    }
    .onoffswitch-label {
        display: block; overflow: hidden; cursor: pointer;
        border: 2px solid #999999; border-radius: 20px;
    }
    .onoffswitch-inner {
        display: block; width: 200%; margin-left: -100%;
        transition: margin 0.3s ease-in 0s;
    }
    .onoffswitch-inner:before, .onoffswitch-inner:after {
        display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
        font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
        box-sizing: border-box;
    }
    .onoffswitch-inner:before {
        content: "ON";
        padding-left: 10px;
        background-color: #34A7C1; color: #FFFFFF;
    }
    .onoffswitch-inner:after {
        content: "OFF";
        padding-right: 10px;
        background-color: #EEEEEE; color: #999999;
        text-align: right;
    }
    .onoffswitch-switch {
        display: block; width: 18px; margin: 6px;
        background: #FFFFFF;
        position: absolute; top: 0; bottom: 0;
        right: 56px;
        border: 2px solid #999999; border-radius: 20px;
        transition: all 0.3s ease-in 0s;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
        margin-left: 0;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
        right: 0px;
    }
		   </style>';

	echo '</div>';

}

function add_a_ten_minutes_schedule( $schedules )
{
	// add a 'weekly' schedule to the existing set
	$schedules['tenminutes'] = array(
		'interval' => 600,
		'display' => __('10 Minutes')
	);
	return $schedules;
}

function add_a_quarter_day_schedule( $schedules )
{
	// add a 'weekly' schedule to the existing set
	$schedules['quarterday'] = array(
		'interval' => 21600,
		'display' => __('Quarter Day')
	);
	return $schedules;
}

add_filter( 'cron_schedules', 'add_a_ten_minutes_schedule' );
add_filter( 'cron_schedules', 'add_a_quarter_day_schedule' );

?>