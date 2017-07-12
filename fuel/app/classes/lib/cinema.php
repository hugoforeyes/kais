<?php

class Lib_Cinema
{
	public static function is_holiday($time)
	{
		return false;
	}

	/**
	 * @param  [type] $show_data  Array ('C' => 'GALAXY', 'T' => 17, 'S' => 'N', ...);
	 */
	public static function process($show_data, $price_data = null)
	{
		if( ! $price_data) {
			Config::load('cinema');
			$price_data = Config::get('PRICE');
		}

		if( ! is_array($price_data)) {
			return $price_data;
		}

		$arr_keys = array_keys($price_data);
		$data_type_key = self::_get_data_type_key($arr_keys);
		foreach ($data_type_key as $type => $data_type) {
			if($type == 'EXTRA')
				continue;
			$key = self::_get_key_by_type($show_data, $type, $data_type);

			if ( ! $key)
				continue;
			$price = self::process($show_data, $price_data[$key]);

			//Special case for location
			if ( ! $price && $type == 'L')
				$price = self::process($show_data, $price_data['L_BASE']);

			if ($price)
				return $price;
		}
		return 0;
	}

	private static function _get_key_by_type($show_data, $type, $data_type)
	{
		if( ! isset($show_data[$type]))
			return NULL;
		if ($type == 'T') {
			$arr_time = [];
			$arr_mapping = [];
			foreach ($data_type as $item) {
				$temp = explode("|", $item);
				$arr_time = array_merge($arr_time, $temp);
				foreach ($temp as $time)
					$arr_mapping[$time] = $item;
			}
			$show_time_data = explode(":", $show_data[$type]);
			$show_time_hour = $show_time_data[0];
			$show_time_min = isset($show_time_data[1]) ? $show_time_data[1] : 0;
			foreach ($arr_time as $time) {
				$time_data = explode(":", $time);
				$time_hour = $time_data[0];
				$time_min = isset($time_data[1]) ? $time_data[1] : 0;
				if($show_time_hour < $time_hour)
					return $type."_".$arr_mapping[$time];
				if($show_time_hour == $time_hour && $show_time_min <= $time_min)
					return $type."_".$item;
			}
		} else {
			foreach ($data_type as $item) {
				if(in_array($show_data[$type], explode("|", $item)))
					return $type."_".$item;
			}
		}
		return NULL;
	}

	/**
	 * This function create array type in same level
	 * Format return
	 * 	array(
	 * 		[C] => ['GALAXY', 'CGV'],
	 * 		....
	 * 	)
	 */
	private static function _get_data_type_key($arr_keys)
	{
		$result = [];
		foreach ($arr_keys as $key) {
			$data_key = explode("_", $key);
			$type = $data_key[0];
			if( ! isset($result[$type]))
				$result[$type] = [];
			if(isset($data_key[1]))
				$result[$type][] = $data_key[1];
		}
		return $result;
	}


}
