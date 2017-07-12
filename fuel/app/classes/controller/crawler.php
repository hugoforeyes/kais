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
class Controller_Crawler extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$data = Model_Crawler::find('all', array('where' => array('delete_flg' => 0)));
		return Response::forge(View::forge('crawler/index', array('data' => $data)));
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_create($id = null)
	{
		$data = array('url' => "", 'website' => "", 'is_edit' => false);
		if ($id) {
			$data['is_edit'] = true;
			$temp = Model_Crawler::find($id);
			$data['crawler'] = json_decode($temp->data, true);
			$data['url'] = $temp->website;
			$data['id'] = $id;
		}

		if(Input::method() == 'POST')
			$data['url'] = Input::post('url');

		if ($data['url']) {
			$html = Lib_Crawler::curl($data['url']);
			$data['website'] = Lib_Crawler::get_content($html);
		}

		return Response::forge(View::forge('crawler/create', $data));
	}

	public function action_save($id = null)
	{
		if(Input::method() == 'POST') {
			$data_post = Input::post();
			$data = json_decode($data_post['crawler_data'], true);
			$crawler = ($id) ? Model_Crawler::find($id) : new Model_Crawler();
			$crawler->name = $data['crawler_name'];
			$crawler->website = $data['website'];
			$crawler->data = $data_post['crawler_data'];
			$crawler->delete_flg = 0;
			$crawler->save();
		}
		return Response::redirect('crawler/get/'.$crawler->id);
	}

	public function action_delete($id = null)
	{
		$crawler = Model_Crawler::find($id);
		$crawler->delete_flg = 1;
		$crawler->save();
		return Response::redirect('crawler');
	}

	public function action_get($id)
	{
		$crawler = Model_Crawler::find($id);
		if( ! $crawler)
			return Response::redirect('crawler/create/');
		$data = array();
		$data['info'] = json_decode($crawler->data, true);
		$data['data'] = Lib_Crawler::get_data($crawler->website, $data['info']);
		return Response::forge(View::forge('crawler/get', $data));
	}
}
