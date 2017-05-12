<?php

class Controller_Api extends Controller
{
	public function action_listen()
	{
		$post_data = json_decode(@$_POST['data'], true);
		return $this->api_data(true, "message", $post_data);
	}

	protected function api_data($success, $message = "", $data = array())
	{
		$data = array();
		$data['success'] = true;
		$data['message'] = $message;
		$data['data'] = $data;
		header('Content-Type: application/json');
		return json_encode($data);
	}
}