<?php
/*
Plugin Name: Wordpress Twitter Bot
Plugin URI: http://newwebmasters.net
Description: Post your blog updates on your Twitter account
Version: 1.0
Author: Chris Charlton
Author URI: http://newwebmasters.net
*/

if(get_option('tb_twitter_username') == "")
{
	add_action('admin_notices', 'show_tb_warning');
}

add_action('admin_menu', 'twitterbot_menu');
add_action('publish_post', 'twitterbot_post');
add_action('save_post', 'twitterbot_save_post_meta');
add_action('edit_form_advanced', 'twitterbot_show_post_option');


function twitterbot_save_post_meta($pid)
{
	//Update our meta value
	if($_POST['do_tb_post'] != "")
	{
		update_tb_meta($pid, $_POST['do_tb_post']);
	}
}


function twitterbot_menu() {
  add_options_page('Twitterbot Options', 'Twitterbot Options', 8, __FILE__, 'twitterbot_options');
}

function show_tb_warning()
{
	echo "<div class=\"error\"><p>Please update your <a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=twitterbot.php\">Twitterbot username and password</a>.</p></div>";
}

function twitterbot_options() {
?>
<div class="wrap">
<h2>Twitterbot Options</h2>
<form method="post" action="options.php">

<?php wp_nonce_field('update-options'); ?>

<h3>Username and Password</h3>

<p>Enter your Twitter username and password to enable Twitterbot to post updates.</p>

<table class="form-table">
<tr valign="top">
<th scope="row">Twitter Username</th>
<td><input type="text" name="tb_twitter_username" value="<?php echo get_option('tb_twitter_username'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Twitter Password</th>
<td><input type="password" name="tb_twitter_pw" value="<?php echo get_option('tb_twitter_pw'); ?>" /></td>
</tr>

</table>

<h3>Tweet prefix options.</h3>

<table class="form-table">

<tr valign="top">
<th scope="row">Prefix for new blog posts:</th>
<td><input type="text" name="tb_new_prefix" size="40" value="<?php echo get_option('tb_new_prefix'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Prefix for updated blog posts:</th>
<td><input type="text" name="tb_update_prefix" size="40" value="<?php echo get_option('tb_update_prefix'); ?>" /></td>
</tr>

</table>


<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="tb_twitter_username,tb_twitter_pw,tb_new_prefix,tb_update_prefix" />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
}

function twitterbot_post($pid)
{
	// Let's post

	if($_POST['action'] != "autosave" and $_POST['post_status'] != "draft") //Don't post when autosaving or when saving a draft
	{

		// Set username and password
		$username = get_option('tb_twitter_username');
		$password = get_option('tb_twitter_pw');

		$title = get_the_title($pid);
		$postlink = get_permalink($pid);

		if($_POST['do_tb_post'] == "")
		{
			$_POST['do_tb_post'] == "yes";
		}

		//Update our meta value
		update_tb_meta($pid, $_POST['do_tb_post']);


//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

		if($_POST['original_post_status'] == 'publish') // We are updating a post, rather than publishing a new one
		{
			$title = get_option('tb_update_prefix') . $title;
		}
		else
		{
			$title = get_option('tb_new_prefix') . $title;
		}

//echo $title;

		//Let's implement the TinyURL
		$t_url = "http://tinyurl.com/api-create.php?url=" . $postlink;
		$url_contents = file_get_contents($t_url);

		//echo "The original length of our tweet is " . strlen($title) . "<br>";
		//echo "The lenth of tiny URL is " . strlen($url_contents) . "<br>";

		$temp_length = (strlen($title)) + (strlen($url_contents));

		//echo "Therefore the total length is " . $temp_length . "<br>";

		if($temp_length > 137) //We use 137 characters as we need three fir the hyphen
		{
			$remaining_chars = 134 - strlen($url_contents);

			//echo "We have shortened our remaining characters, therefore we have " . $remaining_chars . " characters left<br>";

			$title = substr($title, 0, $remaining_chars);
			$title = $title . "...";
		}

		$message = $title . " - " . $url_contents;

		// Twitter API address
		$url = 'http://twitter.com/statuses/update.xml';

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, "$url");
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message&source=wordpresstwitterbot");
		curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
//		echo $buffer;

//		echo "<pre>";
//		print_r($_POST);
//		echo "</pre>";
	}

}

function twitterbot_show_post_option()
{
global $post;

	$notify = get_post_meta($post->ID, 'tb_tweet', true);

	echo "<div id=\"tb_twitterbot\" class=\"postbox\">";
	echo "<h3 class=\"hndle\"><span>Wordpress Twitterbot</span></h3>";
	echo "<div class=\"inside\">Tweet this post to Twitter? ";

	echo "<input id=\"skip_tb_post\" type=\"radio\" name=\"do_tb_post\" value=\"yes\"";
	if($notify == "yes" || $notify == "")
	{
		echo " checked=\"checked\"";
	}
	echo " /> <label for=\"skip_tb_post\">Yes</label> ";


	echo "<input id=\"do_tb_post\" type=\"radio\" name=\"do_tb_post\" value=\"no\"";

	if($notify == "no")
	{
		echo " checked=\"checked\"";
	}

	echo " /> <label for=\"do_tb_post\">No</label>";

	echo "</div>";
	echo "</div>";
}

function update_tb_meta($pid, $value)
{
	if (!update_post_meta($pid, 'tb_tweet', $value)) {
		add_post_meta($pid, 'tb_tweet', $value);
	}
}
?>