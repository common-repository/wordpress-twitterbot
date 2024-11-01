<?php
function marketing_twitter_bot_credentials_page()
{
	$page_title="Marketing Twitter Bot";
	$menu_title=$page_title;
	$capability="manage_options";
	$menu_slug="mtb_menu";
	//add_menu_page(  $page_title, $menu_title, $capability, $menu_slug,  'show_marketing_twitter_bot_credentials' , 'dashicons-twitter');
	$parent_slug = 'mtb_menu';

	add_submenu_page( $parent_slug, $page_title,  $menu_title, $capability, $menu_slug, 'show_marketing_twitter_bot_credentials' );

}

//add_action("admin_menu", "marketing_twitter_bot_credentials_page", 401);
add_action("admin_menu", "mtb_menu");

function mtb_menu()
{
	$page_title="Marketing Twitter Bot";
	$menu_title=$page_title;
	$capability="manage_options";
	$menu_slug="mtb_menu";
	add_menu_page(  $page_title, $menu_title, $capability, $menu_slug,  'show_marketing_twitter_bot_credentials' , 'dashicons-twitter');

}

function show_marketing_twitter_bot_credentials()
{
	if
	($_POST['mtb']=="true")
	{
		update_option('twitter_mtb_consumer_key', $_POST['twitter_mtb_consumer_key']);
		update_option('twitter_mtb_consumer_secret', $_POST['twitter_mtb_consumer_secret']);
		update_option('twitter_mtb_access_token', $_POST['twitter_mtb_access_token']);
		update_option('twitter_mtb_access_token_secret', $_POST['twitter_mtb_access_token_secret']);
		update_option('telegram_mtb_bot_token', $_POST['telegram_mtb_bot_token']);
		update_option('telegram_mtb_allowed_chat_id', $_POST['telegram_mtb_allowed_chat_id']);
		update_option('twitter_mtb_fake_handle', $_POST['twitter_mtb_fake_handle']);

	}else
		{}
	$mtb_ck=get_option('twitter_mtb_consumer_key', true);
	$mtb_cs=get_option('twitter_mtb_consumer_secret', true);
	$mtb_at=get_option('twitter_mtb_access_token', true);
	$mtb_ats=get_option('twitter_mtb_access_token_secret', true);
	$mtb_telegram=get_option('telegram_mtb_bot_token', true);
	$mtb_chatid=get_option('telegram_mtb_allowed_chat_id', true);
	$mtb_fake=get_option('twitter_mtb_fake_handle', true);

?>
<div class="wrap">
<h2><span class="dashicons dashicons-twitter"></span>Marketing Twitterbot Credentials</h2>
		<form method="post" >
		The WordPress TwitterBot should be registered as own App on <a href="https://dev.twitter.com/apps" >https://dev.twitter.com/apps</a>. The credentials you need to put here. (You should be a little careful with them. If somebody has access to your database he could read them.)
		<table>
		<tr><td>Consumer Key:</td><td><input class="regular-text" name="twitter_mtb_consumer_key" value="<?php echo $mtb_ck;
	?>" type="password" size="500" /></td></tr>
		<tr><td>Consumer Secret:</td><td><input class="regular-text" name="twitter_mtb_consumer_secret" type="password" size="500"  value="<?php echo $mtb_cs;
	?>" /></td></tr>
		<tr><td>Access Token:</td><td><input class="regular-text" name="twitter_mtb_access_token"  type="password" size="500" value="<?php echo $mtb_at;
	?>" /></td></tr>
		<tr><td>Access Token Secret:</td><td><input class="regular-text" name="twitter_mtb_access_token_secret" type="password" size="500" value="<?php echo $mtb_ats;
	?>" /></td></tr>
		</table>
		
		<table>
			<tr><td>Telegram Bot Token:</td><td><input class="regular-text" name="telegram_mtb_bot_token" value="<?php echo $mtb_telegram;
		?>" type="text" size="500" /></td></tr>
			<tr><td>Telegram allowed chat id:</td><td><input class="regular-text" name="telegram_mtb_allowed_chat_id" type="text" size="500"  value="<?php echo $mtb_chatid;
		?>" /></td></tr>
			<tr><td>Fake Twitter handle for direct posts:</td><td><input class="regular-text" name="twitter_mtb_fake_handle"  type="text" size="500" value="<?php echo $mtb_fake;
		?>" /></td></tr>
	</table>
	<input name="mtb" type="hidden" value="true" />			
		<input type="submit" class="button primary" />
		</form>
</div>
<?php
}

?>