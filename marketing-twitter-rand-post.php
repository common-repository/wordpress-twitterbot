<?php 
function mtb_show_random_post_tweet()
{
	$rand_query = new WP_Query('orderby=rand&showposts=1&post_status=publish'); 



	// try this with get_the_permalink
	// instead of wp_get_shortlink 
	// has the reason of filtering permalink around

	$utm = '?utm_source=twitter&utm_medium=mtb&utm_campaign=twitter';
	
	if (function_exists('wp_get_googlelink')) {
		
    	$shortlink = wp_get_googlelink(get_the_permalink($rand_query->posts[0]->ID).$utm);
	} else {
    	$shortlink = get_the_permalink($rand_query->posts[0]->ID).$utm;
	}

	$content = strip_shortcodes( strip_tags($rand_query->posts[0]->post_content));
	
	$content_array = explode(".",$content);
	

	
	$rando = array_rand($content_array, 1);
	
	$tweet1= substr($content_array[$rando],0,112);
	
	$tweet1 = str_replace("plugin","#plugin", $tweet1);
	$tweet1 = str_replace("WordPress","#WordPress", $tweet1);
	
	$tweet = $tweet1.'... '.$shortlink;
	return $tweet;
	

}

?>