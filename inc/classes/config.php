<?php namespace HT;

class Config{
	private static $CONFIG = [
		'site-title' => 'ToolApp',
		'dir'					=> 'localhost'
	];

	public static function getConfig($var){
		return self::$CONFIG[$var];
	}
}


?>