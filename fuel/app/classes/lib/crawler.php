<?php

class Lib_Crawler
{
	public static function curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FILETIME, true);
		$data = curl_exec($ch);
		//ob_flush();//Flush the data here
		if ($data === FALSE) {
			echo "cURL Error: " . curl_error($ch);
		}
		curl_close($ch);
		return $data;
	}

	public static function get_content($html)
	{
		$doc = Lib_Crawler::create_dom_object($html);
		//remove href
		$hrefs = $doc->getElementsByTagName('a');
		foreach ($hrefs as $node) {
			$node->setAttribute('data-href', $node->getAttribute("href"));
			$node->setAttribute('href', "#javascript:;");
		}

		return $doc->saveHTML();
	}

	public static function create_dom_object($html)
	{
		$doc = new DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
		libxml_use_internal_errors(false);

		$doc = self::removeAllTag($doc, 'script');
		$doc = self::removeAllTag($doc, 'header');
		$doc = self::removeAllTag($doc, 'footer');
		return $doc;
	}

	public static function removeAllTag($dom, $tagname)
	{
		$tags = $dom->getElementsByTagName($tagname);
		while ($tags->length > 0) {
			$p = $tags->item(0);
			$p->parentNode->removeChild($p);
		}
		return $dom;
	}

	public static function get_data($website, $info)
	{
		$html = Lib_Crawler::curl($website);
		$doc = Lib_Crawler::create_dom_object($html);
		$test = $doc->getElementsByTagName('div');
		$xpath = new DOMXPath($doc);

		$container_query = self::_create_query($info['data_selector']);
		$list_objects = $xpath->query($container_query);

		$result = array();
		foreach ($list_objects as $object_ele) {
			$data = array();
			foreach ($info['property'] as $property) {
				$query = ".".self::_create_query($property['data_selector']); //Add "." because we only want
																			//search in context node
				$property_ele = $xpath->query($query, $object_ele)[0];
				if($property['value_field'] == '$$text') {
					$data[$property['name']] = $property_ele->textContent;
				} else {
					$data[$property['name']] = $property_ele->getAttribute($property['value_field']);
				}
			}
			$result[] = $data;
		}
		return $result;
	}

	private static function _create_query($data_selector)
	{
		$query = "";
		foreach ($data_selector as $item) {
			$query .= "//".strtolower($item['$$tag']);
			foreach ($item as $f => $value) {
				if($f == '$$tag' || $f == '$$ele_index' || $f == '$$order')
					continue;
				$query .= "[@".$f."='".$value."']";
			}
			if(isset($item['$$order']) && $item['$$order']) {
				$query .= "[".$item['$$order']."]";
			}
		}
		return $query;
	}
}
