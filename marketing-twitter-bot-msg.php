<?php

function twitter_message_on_mtb(){

//$mtb_views=(int) get_option("mtb_views", true);
//$mtb_interval=(int) get_option("mtb_interval", true);
// performance change
// if(($mtb_views % $mtb_interval)==0 ){

	$tweets=get_option("mtb_tweetlist",true);

	$tweet=explode("\n",$tweets);

	$tweet_count=count($tweet);
	$randomTweet = rand ( 0 , $tweet_count );

		if($tweet[$randomTweet]!=""){
		$return_tweet=$tweet[$randomTweet];
			}
			else{
			$return_tweet="";
			}


		unset($tweet[$randomTweet]);

		$tweet_new_text="";

			foreach ($tweet as $tweezy){

				if ($tweezy!=""){
				$tweet_new_text=$tweet_new_text.$tweezy."\n";
				}else{}
				
				}



$tweet_new_text=substr($tweet_new_text, 0, -1);

$new_file=update_option("mtb_tweetlist",$tweet_new_text);
//}else{}
//$mtb_views++;
//update_option("mtb_views",$mtb_views);
// performance change
return $return_tweet;
}


   
?>