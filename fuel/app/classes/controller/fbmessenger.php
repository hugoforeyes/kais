<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Fbmessenger extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$sender_id = Input::get('id');
		$data['sender'] = $sender_id;
		$data['films'] = Lib_Movie::get_now_showing();
		header('X-Frame-Options: ALLOW-FROM https://www.messenger.com/');
		return Response::forge(View::forge('fbmessenger/index', $data));
	}

	public function action_whitelist()
	{
		$fb_messenger_apk = new Lib_Fbmessenger();
		if (Input::method() == 'POST') {
			$url_post = $fb_messenger_apk->get_url_whitelist();
			$type = Input::post('submit');
			if($type == "add") {
				$domain = Input::post("domain", NULL);
				if ($domain) {
					$data = ["whitelisted_domains" => [$domain]];
					Lib_Curl::post($url_post, $data);
				}
			} elseif ($type == "del") {
				$data = ["fields" => ["whitelisted_domains"]];
				Lib_Curl::delete($url_post, $data);
			}
		}

		$url = $fb_messenger_apk->get_url_whitelist('get');
		$data = Lib_Curl::get($url);
		if(count($data['data']) > 0) {
			$data_view =['data' => $data['data'][0]['whitelisted_domains']];
		} else {
			$data_view = ['data' => []];
		}

		return Response::forge(View::forge('fbmessenger/whitelist', $data_view));
	}
}
