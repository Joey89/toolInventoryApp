<?php namespace HT;

class Helpers{

	public static function _e($var){
		echo self::htmlChars($var);
	}

	private function htmlChars($var){
		return htmlspecialchars($var);
		
	}

	public static function dd($var, $dd=true){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
		if($dd){
			die();
		}
	}
}



?>