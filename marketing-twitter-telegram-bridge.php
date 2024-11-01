<?php


function ttt_main_admin_page()
{
	$page_title="TTT";
	$menu_title=$page_title;
	$capability="read";
	$menu_slug="ttt";

	add_menu_page ( $page_title, $menu_title, $capability, $menu_slug, 'ttt_render_main_admin__page', 'dashicons-welcome-widgets-menus');

}

//add_action("admin_menu", "ttt_main_admin_page", 203);
function ttt_render_main_admin__page()
{
	echo '<div class="wrap">';
	echo '<h2><span class="dashicons dashicons-welcome-widgets-menus"></span>TTT</h2>';
	echo '<div class="card">';
?>
<pre><?php


the_ttt_process(true);
	// WORDPRESS REST
	?></pre><?php
	echo '</div>';
	echo '</div>';

}


function the_ttt_process($output = false)
{
	

	$update_id_for_all = get_option('telegram_update_id_for_all', true);

	// WORDPRESS ENDS HERE
	
	$token = get_option('telegram_mtb_bot_token', true);
	//$token = '255106868:AAErKDIj43YTJJ2aYUp11ekRKtG0n6hwCWU';
	
	$uurl = "https://api.telegram.org/bot".$token."/getUpdates?offset=".$update_id_for_all;
	$purl = "https://api.telegram.org/bot".$token."/SendMessage";

	// Works in terminal
	$reps= json_decode(file_get_contents($uurl));

	foreach ($reps as $rep)
	{
	
		$count = 0;
		foreach
		($rep as $mess)
		{
		
			if ($output) print_r($mess);
			$update_id = $mess->update_id;
			$chat_id = $mess->message->chat->id;
			$first_name = $mess->message->chat->first_name;
			$text = $mess->message->text;
			if ($output) echo "<br>";
			if ($output) echo $update_id." ".$chat_id." ".$first_name." ".$text."<bR>";

			$allci = get_option('telegram_mtb_allowed_chat_id', true);
			//$allci = '25602980';
			if($chat_id == $allci && strpos($text, '/tweet ') !==FALSE)
			{
			//*________________________________________________________

				$text = str_replace("/tweet ","",$text);

				$scheduled_tweet = get_option("mtp_scheduled_tweets",true);
				$bulk_array = explode("\n",$text);
			
				$tweet_array = array_merge($scheduled_tweet,$bulk_array);
				update_option("mtp_scheduled_tweets", $tweet_array);
				
				$count = count($bulk_array);
				
				ttt_curl("Accepted. $count Tweets scheduled.",$first_name,$chat_id,$purl);
			}
			else
			{
				ttt_curl("Access denied. Text was ".$text,$first_name,$chat_id,$purl);
			}
		}
		
 		$update_id_for_all = $update_id;
 		
 		// WORDPRESS FUNKTION
 		update_option('telegram_update_id_for_all',($update_id+1), false);
 		


	}
	

}

	function ttt_curl($text,$first_name,$chat_id,$url)
	{
	
					
	
					$fields = array(
						'chat_id' => urlencode($chat_id),
						'text' => urlencode( $text ),
						'disable_notification' => true,
					);

					//url-ify the data for the POST
					foreach
					($fields as $key=>$value)
						{ $fields_string .= $key.'='.$value.'&';
					}
					rtrim($fields_string, '&');

					//open connection
					$ch = curl_init();
					//set the url, number of POST vars, POST data
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, count($fields));
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
					//execute post
					$result = curl_exec($ch);

					//close connection
					curl_close($ch);
	
	
	}

?>