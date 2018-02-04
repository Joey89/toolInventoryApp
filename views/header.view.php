<?php
 	use \HT\DB;
	use \HT\Helpers as HH;
	use \HT\Config;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php HH::_e(Config::getConfig('site-title')); ?></title>
	<?php 

		
		$css_path = realpath(__DIR__ . '/..');
		$css_path = substr($css_path, 15, 25);
		$css_path =  $css_path . '\public\css\main.css';

		//HH::dd($path, true);
		
	 ?>
	<link rel="stylesheet" type="text/css" href="<?php HH::_e( $css_path ); ?>">
</head>
<body>
	<div class="HT-container">
	<nav class="toolappnav">
		<ul>
			<li><a href="http://localhost/toolapp/">Tools Home Page</a></li>
			<li><a href="http://localhost/toolapp/create/">Create Tool</a></li>
			<li><a href="http://localhost/toolapp/update">Update Tool</a></li>
			<li><a href="http://localhost/toolapp/delete">Delete Tool</a></li>
		</ul>
	</nav>
