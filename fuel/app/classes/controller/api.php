<?php

class Controller_Api extends Controller
{
	public function action_webhook_fb()
	{
		$fb_apk_messenger = new Lib_Fbmessenger();
		if(Input::method() == 'POST') {
			$data = $fb_apk_messenger->get_info_message();
			$response = Lib_Friday::listen($data['message']);
			if ($response['type'] == Lib_Friday::TYPE_TEXT) {
				$message = $fb_apk_messenger->create_message('text', ['text' => $response['message']]);
			} else {
				$message = $fb_apk_messenger->create_message('button_template', [
					'text' => $response['message'],
					'buttons' => [[
						"type" => "web_url",
						"url" => "https://4d72d474.ngrok.io/kais/public/fbmessenger/?id=".$data['sender'],
						"title" => "Danh sách phim",
						"messenger_extensions" => true,
						"webview_height_ratio" => "tall",
						"fallback_url" => "https://4d72d474.ngrok.io/"
					]]
				]);
			}
			\Log::instance()->log(\Fuel::L_INFO, print_r($message,true));
			$fb_apk_messenger->send_message($data['sender'], $message);
		} else {
			$hub_verify_token = null;
			if(isset($_REQUEST['hub_challenge'])) {
			    $challenge = $_REQUEST['hub_challenge'];
			    $hub_verify_token = $_REQUEST['hub_verify_token'];
			}
			if($fb_apk_messenger->check_token($hub_verify_token))
				return $challenge;
		}
	}

	public function action_fb_message()
	{
		$fb_apk_messenger = new Lib_Fbmessenger();
		if(Input::method() == 'POST') {
			$message = Input::post('msg');
			$sender_id = Input::post('sender');
			$response = Lib_Friday::listen($message);
			$fb_apk_messenger->send_message($sender_id, $response['message']);
		}
	}

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