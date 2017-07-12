<?php
class Controller_Test extends Controller
{
	public function action_index()
	{
		return Response::forge(View::forge('test/index'));
	}

	public function post_run_php()
	{
		$code = Input::post('code');
		if($this->is_json($code))
			return json_encode(array('type' => 'json', 'data' => $code));
		return eval($code);
	}

	public function is_json($str) {
		$json = json_decode($str);
		return $json && $str != $json;
	}
}
