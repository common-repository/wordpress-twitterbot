<?php 

function marketing_twitter_time_functions_page(){
$page_title=__("Tweet times","mtb");
$menu_title=$page_title;
$capability="manage_options";
$menu_slug="Twitter-Time-Function";
$parent_slug="mtb_menu";

add_submenu_page( $parent_slug, $page_title,  $menu_title, $capability, $menu_slug, 'show_marketing_twitter_time_functions');
//add_menu_page ( $page_title, $menu_title, $capability, $menu_slug, 'show_marketing_twitter_time_functions','dashicons-twitter');
wp_enqueue_script('timepicker-script', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.js');
wp_enqueue_style('timepicker-style', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.css');


}

add_action("admin_menu","marketing_twitter_time_functions_page",403);

include("marketing-twitter-scheduled-tweet-daily-external.php");


function show_marketing_twitter_time_functions(){
	
	if(isset($_POST['time-line-tray-save'])){
		update_option("mtp_timeline_tray",$_POST["tweet-time"]);
	}

	echo '<div class="wrap">';
	
	echo '<form class="mtb_form" method="POST">';
		
// 	echo '<div class="card">Debug:<br>';
// 		$times = implode(";", $_POST['tweet-time']);
// 		print_r($_POST['tweet-time']);
// 		echo "<hR>";
// 		print_r(get_option("mtp_timeline_tray",true));
// 	echo '</div>';	
// 		


 	//echo '<div class="card">Debug:<br>';
	$now = current_time("timestamp");
	
	
	if(isset($_POST['time-line-tray-save']))
	{
		$last_time_count = get_option('mtb_last_time_count', true);
		update_option('mtb_last_time_count', count($_POST['tweet-time']));
		
		//echo $now."<br>";
		//echo 	'<b>'.$last_time_count.'</b><br>';
		
		for ($i = 1; $i <= $last_time_count; $i++) {
 			   //echo $i."<br>";
 			   wp_clear_scheduled_hook('mtb_the_scheduled_tweet');
		}
	}
	
	if(isset($_POST['tweet-time']))
	{
	

		
		
		foreach ($_POST['tweet-time'] as $ttime)
		{
			$sched = strtotime($ttime);
			
			$sched = $sched - 3600; // timezone fix
			// 86400
			if($sched < $now)
			{
				$sched = $sched + 86400;
				
			}
			wp_schedule_event( $sched, 'daily', 'mtb_the_scheduled_tweet' );
			//echo $sched ."<br>";
		}
	}
 	//echo '</div>';	



	echo '<h2><span class="dashicons dashicons-twitter"></span> Tweet times</h2>';
	
	echo '<div class="card">';
	echo '<form method="POST">';


	echo __("Add a time or remove by clicking the buttons","mtb");
	echo ' <a href="#"  style="text-decoration:none;"  class="plus"><span class="dashicons dashicons-plus-alt"></span></a> </div><div class="card timeline-tray">';


	$mtp_timeline_tray = get_option("mtp_timeline_tray",true);
	sort($mtp_timeline_tray);
	
	foreach ($mtp_timeline_tray as $element)
	{
		// this is the master line
		echo '<div class="timeline"><input type="text" class="timepicker" value="'.$element.'" name="tweet-time[]" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>';
	}


	// ToDo: Find out how to dynamcally also kill newly created fields
	

	echo '</div><div class="card"><input type="submit" name="time-line-tray-save" class="button-primary" />';

	
	echo '</div>';
	
	
		
	
	echo '<script>
		

			
			jQuery( ".plus" ).on("click", function(){
					jQuery(".timeline-tray").delegate().append(\'<div class="timeline"><input type="text" class="timepicker" name="tweet-time[]" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>\');
			});
	
	
			jQuery( ".minus" ).live("click", function() {
	  				jQuery(this).parent(".timeline").remove();
	  			
			});	

			jQuery("body").on("focus",".timepicker", function(){
    			jQuery(this).timepicker(
    				{
 		    			timeFormat: "HH:mm",
    					interval: 12,
    					dynamic: false,
    					dropdown: true,
    					scrollbar: true
					}
    			);
			});
			
			
		

		</script>';
			
	echo '</form>';
	echo '</div>';

}



?>