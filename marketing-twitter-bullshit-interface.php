<?php 


function marketing_twitter_bullshit_page(){
$page_title='Bullshit Interface  <font color="#ff0000"> DEPRECATED </font>';
$menu_title=$page_title;
$capability="manage_options";
$menu_slug="Twitter-Bullshit-Interface";
$parent_slug="Twitter-Audience";

add_menu_page (  $page_title, $menu_title, $capability, $menu_slug, 'show_marketing_twitter_bullshit_interface','dashicons-twitter');

}

add_action("admin_menu","marketing_twitter_bullshit_page",406);


function show_marketing_twitter_bullshit_interface(){

	if(isset($_POST['bs_sub']))
	{
		update_option("general_bs_word", $_POST['mtb_bullshit_gword']);
		update_option("tweet_sentence_begin", $_POST['tweet_sentence_begin']);
		update_option("header_banner_verb_one", $_POST['verb_one']);
		update_option("header_banner_verb_two", $_POST['verb_two']);
		update_option("header_banner_noun", $_POST['noun']);
		update_option("header_banner_fill", $_POST['fillword']);
		update_option("tweet_sentence_end", $_POST['tweet_sentence_end']);
	}


	echo '<div class="wrap"><form method="post">';
		
	echo '<h2><span class="dashicons dashicons-twitter"></span> Bullshit Interface</h2><small>Uses credentials from Marketing Twitter Bot</small><br>';
	
	echo '<div class="card" style="display:inline-block;margin-right:10px;">Example: ';
	print_r(bg_tweet_make_bullshit());
	echo '</div>';

$mtb_bullshit_gword = get_option("general_bs_word", true);
echo '<div class="card"> General bullshit word where to react<br>
<input type="text" name="mtb_bullshit_gword" value="' . $mtb_bullshit_gword .'" />
<input type="submit" name="bs_sub" class="button-primary" />
</div>';

echo '<div class="tray-words">';

echo '<div class="card sentence-begin">Beginning phrase <a href="#"  style="text-decoration:none;"  class="plus-begin"><span class="dashicons dashicons-plus-alt"></span></a><br>';

	$tweet_sentence_begin = get_option("tweet_sentence_begin", true);
	//echo '<input type="text" value="'.$tweet_sentence_begin.'" name="tweet_sentence_begin" />';
	foreach ( $tweet_sentence_begin as $begin)
	{
		echo '<div class="begin_one"><input type="text" name="tweet_sentence_begin[]" value="'.$begin.'" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>';
	}

echo '</div>';

echo '<div class="card verb-one"> Verbs 1 <a href="#"  style="text-decoration:none;"  class="plus-verb1"><span class="dashicons dashicons-plus-alt"></span></a><br>';

	$verb_one = get_option("header_banner_verb_one",true);
	
	foreach ( $verb_one as $verb)
	{
		echo '<div class="verb_one"><input type="text" name="verb_one[]" value="'.$verb.'" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>';
	}


echo '</div>';

echo '<div class="card verb-two"> Shitword b  <a href="#"  style="text-decoration:none;"  class="plus-verb2"><span class="dashicons dashicons-plus-alt"></span></a><bR>';
	
	$verb_two = get_option("header_banner_verb_two",true);
	
	foreach ( $verb_two as $verb)
	{
		echo '<div class="verb_two"><input type="text" name="verb_two[]" value="'.$verb.'" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>';
	}

	
echo '</div>';

echo '<div class="card card-noun"> Shitword c  <a href="#"  style="text-decoration:none;"  class="plus-noun"><span class="dashicons dashicons-plus-alt"></span></a><bR>';
	$nouns = get_option("header_banner_noun",true);
	
	foreach ( $nouns as $noun)
	{
		echo '<div class="noun"><input type="text" name="noun[]" value="'.$noun.'" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>';
	}
echo '</div>';

echo '<div class="card card-fill"> Shitword FIll <a href="#"  style="text-decoration:none;"  class="plus-fill"><span class="dashicons dashicons-plus-alt"></span></a><bR>';
	$fillwords = get_option("header_banner_fill",true);
	
	foreach ( $fillwords as $fillword)
	{
		echo '<div class="fillword"><input type="text" name="fillword[]" value="'.$fillword.'" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>';
	}
	
echo '</div>';

echo '<div class="card card-ending">ending phrase  <a href="#"  style="text-decoration:none;"  class="plus-ending"><span class="dashicons dashicons-plus-alt"></span></a><br>';

	$tweet_sentence_end = get_option("tweet_sentence_end", true);
	//echo '<input type="text" value="'.$tweet_sentence_end.'" name="tweet_sentence_end" />';
	foreach ( $tweet_sentence_end as $end)
	{
		echo '<div class="end_one"><input type="text" name="tweet_sentence_end[]" value="'.$end.'" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>';
	}
	
	

echo '</div>';

echo '</div>'; // tray-words

echo '<style>
.tray-words .card {

	display:inline-block;
	vertical-align:top;
	padding:2px;
	min-width: 100px;
    max-width: 220px;
    margin-right:2px;
    border: 1px solid #e5e5e5 !important;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04);
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
    background: #fff;
    
}
</style>';

echo '<script>
	jQuery( ".minus" ).live("click", function() {
	  				jQuery(this).parent().remove();
	  			
			});	
			
	jQuery( ".plus-begin" ).on("click", function(){
					jQuery(".sentence-begin").delegate().append(\'<div class="begin_one"><input type="text" name="tweet_sentence_begin[]"  /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>\');
			});
			
	jQuery( ".plus-verb1" ).on("click", function(){
					jQuery(".verb-one").delegate().append(\'<div class="verb_one"><input type="text" name="verb_one[]"  /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>\');
			});
			
	jQuery( ".plus-verb2" ).on("click", function(){
					jQuery(".verb-two").delegate().append(\'<div class="verb_two"><input type="text" name="verb_two[]"  /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>\');
			});
			
	jQuery( ".plus-noun" ).on("click", function(){
					jQuery(".card-noun").delegate().append(\'<div class="noun"><input type="text" name="noun[]" /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>\');
			});
	jQuery( ".plus-fill" ).on("click", function(){
					jQuery(".card-fill").delegate().append(\'<div class="fillword"><input type="text" name="fillword[]"  /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>\');
			});
	jQuery( ".plus-ending" ).on("click", function(){
					jQuery(".card-ending").delegate().append(\'<div class="end_one"><input type="text" name="tweet_sentence_end[]"  /> <a style="text-decoration:none;" class="minus"><span class="dashicons dashicons-dismiss"></span></a></div>\');
			});
		
			</script>';



	echo '</form></div>';

}

?>