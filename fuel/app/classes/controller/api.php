<?php

class Controller_Api extends Controller
{
	public function action_listen()
	{
		$response = Lib_Friday::listen(@$_POST['msg']);
		return $this->api_data(true, $response);
	}

	protected function api_data($success, $response = array())
	{
		$data = array();
		$data['success'] = true;
		$data['data'] = $response;
		header('Content-Type: application/json');
		return json_encode($data);
	}
}