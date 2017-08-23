<?php

class Lib_Fpt
{
	protected static $_key = "61289214f5104fb9acc55c49fce9f83c";

	public static function get($url, $data, $headers)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://api.openfpt.vn/text2speech/v4");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = array_merge($headers, [
		    'api_key: '.self::$_key,
		    'Cache-Control: no-cache'
		]);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response, true);
	}

	public static function text2speech($text) 
	{
		$url = "http://api.openfpt.vn/text2speech/v4";
		$headers = [
		    'speech: 2',
		    'voice: hatieumai',
		    'prosody: 1',
		];
		$data = Lib_Fpt::get($url, $text, $headers);
		if(isset($data["async"]))
			return $data['async'];
		return false;
	}
}
