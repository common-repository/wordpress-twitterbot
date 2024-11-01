<?php

// Semantische Funktionen

function get_essence($value)
{

		$dss_value = strtolower ($value);
		
		$dss_value = ds_url_cleaner($dss_value);
		
		$dss_value = str_replace("ü","ue",$dss_value);
		$dss_value = str_replace("ä","ae",$dss_value);
		$dss_value = str_replace("ö","oe",$dss_value);
		$dss_value = str_replace("ß","ss",$dss_value);
		
		$dss_value = preg_replace("/[^a-zA-Z\s]/", "", $dss_value);
		
		$ds_tweetlist=get_option('ds_tweetlist',true);
	
		$ignore_words_array = explode(' ',$ds_tweetlist);
		
		$those_question_words = explode(' ',$dss_value);
		
		$tqwo = array_values(array_diff($those_question_words,$ignore_words_array));
		
		$dss_value = implode(' ', $tqwo);
		
		return $dss_value;
}

function get_essence_small($value)
{

		$dss_value = strtolower ($value);
		
		$dss_value = str_replace("ü","ue",$dss_value);
		$dss_value = str_replace("ä","ae",$dss_value);
		$dss_value = str_replace("ö","oe",$dss_value);
		$dss_value = str_replace("ß","ss",$dss_value);
		
		return $dss_value;
}

function get_word_frequency($words)
{
	$words_array = array_count_values(str_word_count($words, 1)) ;
	
	arsort($words_array);
	
	foreach($words_array as $key => $value)
	{
		if (strlen($key) < 6)
		{
 			unset($words_array[$key]);
 		}
	}
	
	return $words_array;
}

function first_words($words)
{

	$output = array_slice($words, 0, 10); 

	return $output;
}

function more_words($words)
{

	$output = array_slice($words, 0, 100); 

	return $output;
}

function write_a_textblock($words)
{

	$words = implode(" ",$words);
	
	return $words;

}


function first_two_words($words)
{
//Now 2 again
// Lol 
	$o = array_slice($words, 0, 3);  
Unset($o[1]);

	return $o;
}

function write_a_new_sentence($words, $shuffle = "no")
{

	$count=0;
	foreach ($words as $key => $value)
	{
	$word[$key] = $count;
	
	$count++;
	}
	
	$words = array_flip($word);
	if($shuffle=='yes')
	{
	shuffle($words);
	}
	$words = implode(" ",$words);
	
	return $words;

}

function write_a_new_sentence_no_flip($words)
{

	$words = implode(" ",$words);
	
	return $words;

}




// http://stackoverflow.com/questions/1113840/php-remove-url-from-string
function ds_url_cleaner($url) {
  $U = explode(' ',$url);

  $W =array();
  foreach ($U as $k => $u) {
    if (stristr($u,'https') || (count(explode('.',$u)) > 1)) {
      unset($U[$k]);
      return ds_url_cleaner( implode(' ',$U));
    }
  }
  return implode(' ',$U);
}


?>