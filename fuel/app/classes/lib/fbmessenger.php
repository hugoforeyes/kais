<?php

class Lib_Fbmessenger
{
	protected $_access_token = "EAAaV4pZCpYBEBAE84Fm6ToLkRmT770nQ71An3DjVBJIAN464hSZCRm1pzcalyxoyoaDl8ojQeJZBfLKkvdG8P5RiU14xWPG2Au0nM29Dlade4HcwmB31zjtkdoFK7WLRpnZBjNpQqC3fOIgikC5XSdquVhGEbWZB8XjaVnDfp18OrF762JUHJ";
	protected $_verify_token = "jvsfriday_facebook";
	protected $_url = "https://graph.facebook.com/v2.6/me/messages";


	public function check_token($token) {
		if ($token == $this->_verify_token)
			return true;
		return false;
	}

	public function get_url_whitelist($type = null) {
		$url = "https://graph.facebook.com/v2.6/me/messenger_profile?";
		switch ($type) {
			case 'get':
				$url .= "fields=whitelisted_domains&";
			default:
				$url .= "access_token=".$this->_access_token;
				break;
		}
		return $url;
	}

	public function get_info_message() {
		$input = json_decode(file_get_contents('php://input'),true);
		\Log::instance()->log(\Fuel::L_INFO, print_r($input, true));
		$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
		$message = $input['entry'][0]['messaging'][0]['message']['text'];
		return ["sender" => $sender, "message" => $message];
	}

	public function create_message($type, $data) {
		$template = [
			'attachment' => [
				'type' => 'template',
				'payload' => []
			]
		];
		switch ($type) {
			case 'text':
				return ['text' => $data['text']];
			case 'button_template':
				$template['attachment']['payload'] = [
					'template_type' => 'button',
					'text' => $data['text'],
					'buttons' => $data['buttons']
				];
				return $template;
		}
		return false;
	}

	public function send_message($sender, $message) {
		$data = ['recipient' => ['id' => $sender], 'message' => $message];

		//$data = ["recipient" => ["id" => $sender], "message" => ["text" => $msg]];
		
		// $data = [
		// 	"recipient" => ["id" => $sender],
		// 	"message" => [
		// 		"attachment" => [
  //     				"type" => "template",
  //     				"payload" => [
  //       				"template_type" => "list",
  //       				"elements" => [
  //       					"title" => "HAHA",
		// 			        "buttons" => [
		// 			        	[
		// 			        		"type" => "web_url",
		// 				            "url" => "https://www.messenger.com",
		// 				            "title" => "Visit Messenger"
		// 			        	]
		// 				    ]
  //       				]
		// 			]
		// 		]
	 //        ]
	 //    ];


	  //   $data = [
			// "recipient" => ["id" => $sender],
			// "message" => [
			// 	"attachment" => [
   //    				"type" => "template",
   //    				"payload" => [
   //      				"template_type" => "list",
   //      				"top_element_style" => "large",
   //      				"elements" => [
   //      					[
	  //       					"title" => "HIU",
	  //       					"subtitle" => "See all our colors",
	  //       					"image_url" => "https://umami-me.atlassian.net/images/64jira.png",
			// 			        "buttons" => [
			// 			        	[
			// 			        		"type" => "web_url",
			// 				            "url" => "https://4d72d474.ngrok.io/kais/public/fbmessenger/?id=".$sender,
			// 				            "title" => "Visit Messenger",
			// 				            "messenger_extensions" => true,
   //              						"webview_height_ratio" => "tall",
   //              						"fallback_url" => "https://4d72d474.ngrok.io/"
			// 			        	]
			// 				    ]
			// 				],
			// 				[
	  //       					"title" => "HIU",
	  //       					"subtitle" => "See all our colors",
	  //       					"image_url" => "https://umami-me.atlassian.net/images/64jira.png",
			// 			        "buttons" => [
			// 			        	[
			// 			        		"type" => "web_url",
			// 				            "url" => "https://www.messenger.com",
			// 				            "title" => "Visit Messenger"
			// 			        	]
			// 				    ]
			// 				],
   //      				]
			// 		]
			// 	]
	  //       ]
	  //   ];


		// $data = [
		// 	"recipient" => ["id" => $sender],
		// 	"message" => [
		// 		"attachment" => [
  //     				"type" => "template",
  //     				"payload" => [
  //       				"template_type" => "generic",
  //       				"elements" => [
  //       					[
	 //        					"title" => "HIU",
	 //        					"subtitle" => "See all our colors",
	 //        					"image_url" => "https://umami-me.atlassian.net/images/64jira.png",
		// 				        "buttons" => [
		// 				        	[
		// 				        		"type" => "web_url",
		// 					            "url" => "http://4d72d474.ngrok.io/kais/public/fbmessenger/",
		// 					            "title" => "Visit Messenger",
		// 					            "messenger_extensions" => true,
		// 					            "webview_height_ratio" => "tall"
		// 				        	]
		// 					    ]
		// 					]
  //       				]
		// 			]
		// 		]
	 //        ]
	 //    ];


		$data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		\Log::instance()->log(\Fuel::L_INFO, print_r($data,true));
		
		$url = $this->_url."?access_token=".$this->_access_token;
		\Log::instance()->log(\Fuel::L_INFO, $url);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);
		\Log::instance()->log(\Fuel::L_INFO, print_r($result, true));
		return $result;
	}

}