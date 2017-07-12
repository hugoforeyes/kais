<?php
use Orm\Model;
/**
 * Feb 11, 2015
 * Client for Streamed oauth
 * @author dinhhc
 */
class Model_Crawler extends Model
{
	protected static $_table_name = 'crawler';
	protected static $_primary_key = array('id');

	protected static $_properties = array(
		'id',
		'name',
		'website',
		'data',
		'delete_flg',
	);

	protected $default_val = array(
		'delete_flg' => 0,
	);
}
