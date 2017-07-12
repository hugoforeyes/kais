<?php
use Orm\Model;
/**
 * Feb 11, 2015
 * Client for Streamed oauth
 * @author dinhhc
 */
class Model_Movie extends Model
{
	protected static $_table_name = 'movie';
	protected static $_primary_key = array('id');

	protected static $_properties = array(
		'id',
		'name',
		'img',
		'release_date',
		'order',
		'website_link',
		'detail',
		'delete_flg',
		'create_date',
	);

	protected $default_val = array(
		'delete_flg' => 0,
	);
}
