<?php

class Lib_Min
{
	public static function listen($sentence)
	{
		$words = Lib_Vntokenize::tokenize($sentence);
		return implode(" ", $words);
		if($sentence == "Chào")
			return "Xin chào!";
		return "Cậu nói gì tớ không hiểu, nhưng tớ vẫn yêu cậu! :)";
	}
}
