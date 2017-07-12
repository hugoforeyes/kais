<?php

class Lib_Friday
{
	const TYPE_TEXT = 1;
	const TYPE_MOVIE_LIST = 2;
	const TYPE_MOVIE_DETAIL = 3;
	const TYPE_YOUTUBE = 4;

	public static function listen($sentence)
	{
		//$words = Lib_Vntokenize::tokenize($sentence);
		//return implode(" ", $words);
		// $test = Lib_Min::curl_google("test");
		// echo "<pre>";
		// print_r($test);
		// die();
		if($sentence == "Chào")
			return self::_response("Xin chào!");
		if($sentence == "phim") {
			$data = Lib_Movie::get_now_showing();
			return self::_response("Các phim này đang chiếu ở rạp nè!", self::TYPE_MOVIE_LIST, $data);
		}
		if($sentence == "Xem phim số 1") {
			$data = Lib_Movie::show_detail(0);
			return self::_response("Thông tin film ".$data['vi_name'], self::TYPE_MOVIE_DETAIL, $data);
		}
		if($sentence == "xem trailer") {
			$youtube_id = Lib_Movie::get_trailer(0);
			return self::_response("Trailer của phim đó nè!", self::TYPE_YOUTUBE, $youtube_id);
		}
		return self::_response("Cậu nói gì tớ không hiểu, nhưng tớ vẫn yêu cậu! :)");
	}

	private static function _response($msg, $type = self::TYPE_TEXT, $data = array())
	{
		return array('message' => $msg, 'type' => $type, 'data' => $data);
	}

	// public static function curl_google($keyword){
	// 	$ch = curl_init();
	// 	curl_setopt($ch, CURLOPT_URL,
	// 	'http://www.google.com/search?hl=en&q='.urlencode($keyword).'&btnG=Google+Search&meta=');
	// 	curl_setopt($ch, CURLOPT_HEADER, 1);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	curl_setopt($ch, CURLOPT_FILETIME, true);
	// 	$data = curl_exec($ch);
	// 	//ob_flush();//Flush the data here
	// 	if ($data === FALSE) {

	// 		echo "cURL Error: " . curl_error($ch);

	// 	}
	// 	curl_close($ch);

	// 	return $data;
	// }
}
