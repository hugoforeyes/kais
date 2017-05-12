<?php

class Controller_Api extends Controller
{
	public function action_listen()
	{
		return $this->api_data(true, Lib_Min::listen(@$_POST['msg']));
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