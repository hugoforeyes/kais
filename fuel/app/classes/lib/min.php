<?php

class Lib_Min
{
	public static function listen($sentence)
	{
		if($sentence == "Chào")
			return "Xin chào!";
		return "Cậu nói gì tớ không hiểu";
	}
}
