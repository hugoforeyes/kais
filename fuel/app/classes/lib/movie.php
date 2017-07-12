<?php
/**
 * This lib get data from 123phim.vn
 */
class Lib_Movie
{
	const ID_NOW_SHOWING = 2;
	const ID_SHOW_DETAIL = 3;

	public static function get_now_showing()
	{
		$time = strtotime('today midnight');
		$data = DB::select()->from('movie')->where('create_date', $time)->execute()->as_array();
		if($data)
			return $data;

		//Get data in the first time
		$crawler = Model_Crawler::find(self::ID_NOW_SHOWING);
		if( ! $crawler)
			return array();
		$data = Lib_Crawler::get_data($crawler->website, json_decode($crawler->data, true));

		//Refresh database
		\DBUtil::truncate_table('movie');
		$query = \DB::insert('movie')->columns(array('name', 'img', 'release_date', 'order', 'website_link', 'delete_flg', 'create_date'));
		foreach ($data as $index => $item) {
			$query->values(array($item['name'], $item['img'], $item['publish_day'].$item['publish_month'], $index, 'http://www.123phim.vn/'.$item['href'], 0, $time));
		}
		$query->execute();

		//Get from database again
		$data = DB::select()->from('movie')->where('create_date', $time)->execute()->as_array();
		return $data;
	}

	public static function show_detail($order, $movie = null)
	{
		if( ! $movie)
			$movie = Model_Movie::find('first', array('where' => array('order' => $order, 'delete_flg' => 0)));
		if( ! $movie)
			return array();
		if($movie->detail)
			return json_decode($movie->detail, true);
		$crawler = Model_Crawler::find(self::ID_SHOW_DETAIL);
		if( ! $crawler)
			return array();
		$result = Lib_Crawler::get_data($movie->website_link, json_decode($crawler->data, true))[0];
		$movie->detail = json_encode($result, JSON_UNESCAPED_UNICODE);
		$movie->save();
		return $result;
	}

	public static function get_trailer($order)
	{
		$movie = Model_Movie::find('first', array('where' => array('order' => $order, 'delete_flg' => 0)));
		if( ! $movie)
			return array();
		$detail = json_decode($movie->detail, true);
		if( ! $detail)
			$detail = self::show_detail($order, $movie);
		if( ! $detail)
			return array();
		return $detail['media_id'];
	}

	public static function get_session_time($film_id, $time = NULL, $cinema = 0, $city = 1)
	{
		$cities = array (
			1 => "Hồ Chí Minh", 2 => "Hà Nội", 3 => "Đà Nẵng", 4 => "Hải Phòng", 5 => "Biên Hoà", 6 => "Nha Trang",
			7 => "Bình Dương", 8 => "Phan Thiết", 9 => "Hạ Long", 10 => "Cần Thơ", 11 => "Vũng Tàu",
			12 => "Quy Nhơn", 13 => "Huế", 14 => "Long Xuyên", 15 => "Thái Nguyên",16 => "Buôn Ma Thuột",
			17 => "Bắc Giang", 18 => "Bến Tre", 19 => "Việt Trì", 20 => "Ninh Bình", 21 => "Thái Bình",
			22 => "Vinh", 23 => "Bảo Lộc", 24 => "Đà Lạt", 25 => "Trà Vinh", 26 => "Yên Bái", 27 => "Kiên Giang",
			28 => "Vĩnh Long", 29 => "Cà Mau",
		);

		$cinemas = array (
			0 => "Tất cả",
			1 => "Lotte Cinema",
			2 => "Galaxy Cinema",
			3 => "CGV Cinemas",
			4 => "BHD Star Cineplex",
			6 => "DDC - Đống Đa",
			16 => "CineStar",
			17 => "Mega GS",
		);

		$cities_cinema = array (
			1 => array(0, 1, 2, 3, 4, 6, 16, 17)
		);

		if ( ! $time)
			$time = date('Y-m-d');

		$url = "http://www.123phim.vn/default/ajax/?method=Session.getListGroupByCinemaNew";
		$url .= "&locationId=" .$city;
		$url .= "&filmId=". $film_id;
		$url .= "&date=". $time;
		$url .= "&pcinemaId=" . $cinema;

		$data = Lib_Crawler::curl($url);
		print_r(json_decode($data, true));

	}

	/******************
	 * TINH TOAN GIA VE
	 ******************/
	public static function price_galaxy($film_type, $people_type, $seat_type, $time)
	{
		$price = array(
			'FILM_2D' => array(
				'NORMAL_DAY' => array(
					'BEFORE_17PM' => array(
						'PEOPLE_ADULT' => 65000,
						'PEOPLE_STUDENT' => 60000,
						'PEOPLE_CHILDREN' => 50000,
						'PEOPLE_TEENSTAR' => 55000,
					),
					'BEFORE_24PM' => array(
						'PEOPLE_ADULT' => 75000,
						'PEOPLE_STUDENT' => 60000,
						'PEOPLE_CHILDREN' => 50000,
						'PEOPLE_TEENSTAR' => 55000,
					),
				),
				'HAPPY_DAY' => array(
					'PEOPLE_ADULT' => 55000,
					'PEOPLE_STUDENT' => 55000,
					'PEOPLE_CHILDREN' => 50000,
					'PEOPLE_TEENSTAR' => 55000,
				),
				'WEEKEND' => array(
					'PEOPLE_ADULT' => 85000,
					'PEOPLE_STUDENT' => 60000,
					'PEOPLE_CHILDREN' => 55000,
					'PEOPLE_TEENSTAR' => 60000,
				),
				'HOLIDAY' => array(
					'PEOPLE_ADULT' => 85000,
					'PEOPLE_STUDENT' => 85000,
					'PEOPLE_CHILDREN' => 55000,
					'PEOPLE_TEENSTAR' => 85000,
				),

			),
			'FILM_3D' => array(
				'NORMAL_DAY' => array(
					'BEFORE_12PM' => array('NORMAL_SEAT' => 70000, 'VIP_SEAT' => 80000),
					'BEFORE_17PM' => array('NORMAL_SEAT' => 80000, 'VIP_SEAT' => 100000),
					'BEFORE_19PM' => array('NORMAL_SEAT' => 100000, 'VIP_SEAT' => 120000),
					'BEFORE_21PM' => array('NORMAL_SEAT' => 100000, 'VIP_SEAT' => 120000),
					'BEFORE_24PM' => array('NORMAL_SEAT' => 80000, 'VIP_SEAT' => 100000),
				),
				'HAPPY_DAY' => 80000,
				'WEEKEND' => array(
					'BEFORE_12PM' => array('NORMAL_SEAT' => 85000,'VIP_SEAT' => 95000),
					'BEFORE_17PM' => array('NORMAL_SEAT' => 100000,'VIP_SEAT' => 110000),
					'BEFORE_19PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 140000),
					'BEFORE_21PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 160000),
					'BEFORE_24PM' => array('NORMAL_SEAT' => 110000,'VIP_SEAT' => 120000),
				),
				'HOLIDAY' => array(
					'BEFORE_12PM' => array('NORMAL_SEAT' => 85000,'VIP_SEAT' => 95000),
					'BEFORE_17PM' => array('NORMAL_SEAT' => 100000,'VIP_SEAT' => 110000),
					'BEFORE_19PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 140000),
					'BEFORE_21PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 160000),
					'BEFORE_24PM' => array('NORMAL_SEAT' => 110000,'VIP_SEAT' => 120000),
				),
			),
			'FILM_3D_TEENSTAR' => array(
				'NORMAL_DAY' => array(
					'BEFORE_12PM' => array('NORMAL_SEAT' => 70000, 'VIP_SEAT' => 70000),
					'BEFORE_17PM' => array('NORMAL_SEAT' => 70000, 'VIP_SEAT' => 70000),
					'BEFORE_19PM' => array('NORMAL_SEAT' => 100000, 'VIP_SEAT' => 120000),
					'BEFORE_21PM' => array('NORMAL_SEAT' => 100000, 'VIP_SEAT' => 120000),
					'BEFORE_24PM' => array('NORMAL_SEAT' => 80000, 'VIP_SEAT' => 100000),
				),
				'HAPPY_DAY' => 80000,
				'WEEKEND' => array(
					'BEFORE_12PM' => array('NORMAL_SEAT' => 80000,'VIP_SEAT' => 80000),
					'BEFORE_17PM' => array('NORMAL_SEAT' => 90000,'VIP_SEAT' => 90000),
					'BEFORE_19PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 140000),
					'BEFORE_21PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 160000),
					'BEFORE_24PM' => array('NORMAL_SEAT' => 110000,'VIP_SEAT' => 120000),
				),
				'HOLIDAY' => array(
					'BEFORE_12PM' => array('NORMAL_SEAT' => 85000,'VIP_SEAT' => 95000),
					'BEFORE_17PM' => array('NORMAL_SEAT' => 100000,'VIP_SEAT' => 110000),
					'BEFORE_19PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 140000),
					'BEFORE_21PM' => array('NORMAL_SEAT' => 120000,'VIP_SEAT' => 160000),
					'BEFORE_24PM' => array('NORMAL_SEAT' => 110000,'VIP_SEAT' => 120000),
				),
			),
		);
		$date_data = array(
			'NORMAL_DAY' => array(2,4,5),
			'HAPPY_DAY' => 3,
			'WEEKEND' => array(7,1),
		);


		$day_of_week = date("w", $time) + 1;
		$date_type = 'HAPPY_DAY';
		if (1 < $day_of_week && $day_of_week < 6 && $day_of_week != 3)
			$date_type = 'NORMAL_DAY';
		if ($day_of_week == 1 || $day_of_week > 5)
			$date_type = 'WEEKEND';


		$hour = intval(date("H", $time));


	}

	private static function _get_price($data_price, $array_keys)
	{
		if( ! is_array($data_price))
			return $data_price;
		$key = array_shift($array_keys);
		return self::_get_price($data_price[$key], $array_keys);
	}
}
