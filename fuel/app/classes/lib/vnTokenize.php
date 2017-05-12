<?php

class Lib_Vntokenize
{
	public static function tokenize($sentence)
	{
		file_put_contents(DOCROOT."../vntokenizer/input.txt", $sentence);
		Lib_Vntokenize::run();
		$data_text = file_get_contents(DOCROOT."../vntokenizer/output.txt");
		return explode(" ", $data_text);
	}

	public static function run()
	{
		chdir(DOCROOT."../vntokenizer");
		exec("sh vnTokenizer.sh -i input.txt -o output.txt", $text_data);
		chdir(DOCROOT);
		return $text_data;
	}
}
