<?php

function marketing_twitter_bot_page(){
$page_title='Legacy Twitterbot <font color="#ff0000"> DEPRECATED </font>';
$menu_title=$page_title;
$capability="manage_options";
$menu_slug="WordPress-Twitterbot";
$parent_slug="WordPress-Twitterbot-Credentials";

add_menu_page( $page_title, $menu_title, $capability, $menu_slug,  'show_marketing_twitter_bot','dashicons-twitter');//  , 
}

add_action("admin_menu","marketing_twitter_bot_page", 410);

function show_marketing_twitter_bot(){

if($_POST['mtb']=="true"){

update_option('mtb_interval',$_POST['mtb_interval']);
update_option('mtb_tweetlist',$_POST['tweetlist']);

}else{}


$mtb_i=get_option('mtb_interval',true);
$mtb_tweetlist=get_option('mtb_tweetlist',true);
$mtb_views=(int) get_option("mtb_views", true);
?>
<div class="wrap"><div id="icon-tools" class="icon32"></div>
<h2>WordPress Twitterbot</h2>
		
		<div class="wrap">
		<form method="post" >

		<h3>Here you can make a list of Random Tweets</h3>
				<i><b>Intervals:</b></i><br />
		
		Tweet every		<select name="mtb_interval">
		<?php
		$i=0; 
		while ($i<10000){
		echo "<option name=\"".$i."\"";
		if($mtb_i==$i){
		echo " selected ";
		}else{}
		
		echo ">".$i."</option>";
		$i++;
		} ?>
		</select> requests.<?php echo "(".$mtb_views." requests in total)"; ?>
		<hr>

		<textarea name="tweetlist" cols="100" style="height:400px;"><?php echo $mtb_tweetlist; ?></textarea><br />
		<input type="hidden" name="mtb" value="true" />
		<input type="submit" />
		</form>
		</div>	
		
</div><hr><?php
	$friday = get_option("ff_date_txt",false);
	echo 'last friday was '.$friday;

}

?>