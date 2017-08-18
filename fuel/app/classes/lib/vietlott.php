<?php
/**
 * This lib get data from 123phim.vn
 */
class Lib_Vietlott
{
	const ID_MEGA6 = 7;

	public static function get_mega6()
	{
		$crawler = Model_Crawler::find(self::ID_MEGA6);
		if( ! $crawler)
			return array();
		$result = Lib_Crawler::get_data($crawler->website, json_decode($crawler->data, true))[0];
		for ($i=1; $i < 7; $i++) { 
			preg_match("/http:\/\/static.vietlott.vn\/media\/ball\/(.*?)\.png\?v=2\.8/", $result["num_".$i], $match);
			$result["num_".$i] = $match[1];
		}
		return $result;
	}
}