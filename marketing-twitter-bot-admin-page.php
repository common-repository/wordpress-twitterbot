<?php

function marketing_twitter_bot_page(){
$page_title="WordPress Twitterbot";
$menu_title=$page_title;
$capability="manage_options";
$menu_slug="WordPress-Twitterbot";
add_submenu_page( 'tools.php', $page_title, $menu_title, $capability, $menu_slug, "show_marketing_twitter_bot" );
}

add_action("admin_menu","marketing_twitter_bot_page");

function show_marketing_twitter_bot(){

if($_POST['mtb']=="true"){
update_option('twitter_mtb_consumer_key',$_POST['twitter_mtb_consumer_key']);
update_option('twitter_mtb_consumer_secret',$_POST['twitter_mtb_consumer_secret']);
update_option('twitter_mtb_access_token',$_POST['twitter_mtb_access_token']);
update_option('twitter_mtb_access_token_secret',$_POST['twitter_mtb_access_token_secret']);
update_option('mtb_interval',$_POST['mtb_interval']);
update_option('mtb_tweetlist',$_POST['tweetlist']);

}else{}

$mtb_ck=get_option('twitter_mtb_consumer_key',true);
$mtb_cs=get_option('twitter_mtb_consumer_secret',true);
$mtb_at=get_option('twitter_mtb_access_token',true);
$mtb_ats=get_option('twitter_mtb_access_token_secret',true);
$mtb_i=get_option('mtb_interval',true);
$mtb_tweetlist=get_option('mtb_tweetlist',true);
$mtb_views=(int) get_option("mtb_views", true);
?>
<div class="wrap"><div id="icon-tools" class="icon32"></div>
<h2>WordPress Twitterbot</h2>
		
		<div class="wrap">
		<form method="post" >
		The WordPress TwitterBot should be registered as own App on <a href="https://dev.twitter.com/apps" >https://dev.twitter.com/apps</a>. The credentials you need to put here. (You should be a little careful with them. If somebody has access to your database he could read them.)
		<table>
		<tr><td>Consumer Key:</td><td><input class="regular-text" name="twitter_mtb_consumer_key" value="<?php echo $mtb_ck; ?>" type="password" size="500" /></td></tr>
		<tr><td>Consumer Secret:</td><td><input class="regular-text" name="twitter_mtb_consumer_secret" type="password" size="500"  value="<?php echo $mtb_cs; ?>" /></td></tr>
		<tr><td>Access Token:</td><td><input class="regular-text" name="twitter_mtb_access_token"  type="password" size="500" value="<?php echo $mtb_at; ?>" /></td></tr>
		<tr><td>Access Token Secret:</td><td><input class="regular-text" name="twitter_mtb_access_token_secret" type="password" size="500" value="<?php echo $mtb_ats; ?>" /></td></tr>
		</table>

		<input type="hidden" name="mtb" value="true" />
		<input type="submit" />
		</form>
		<hr>
					More interactive support you get on Twitter.<br>
			Join us and see how the world of WordPress plugins is changing.<br>
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.org/plugins/wordpress-twitterbot/" data-text="#WordPress #Twitter #Bot " data-via="wpplugindevcom" data-hashtags="WordPress">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> 
<a href="https://twitter.com/wpplugindevcom" class="twitter-follow-button" data-show-count="false">Follow @wpplugindevcom</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> 
<a href="https://twitter.com/intent/tweet?button_hashtag=wptb" class="twitter-hashtag-button" data-related="wpplugindevcom">Tweet #wptb</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> 
<a href="https://twitter.com/intent/tweet?screen_name=wpplugindevcom" class="twitter-mention-button" data-related="wpplugindevcom">Tweet to @wpplugindevcom</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script> 
		</div>
		</div>	
		
</div><?php
	

}

?>