<?php 
$err_path = realpath(dirname(__FILE__) . '/..');
require_once($err_path . '/vendor/autoload.php');

use \HT\Helpers as HH;
?>

<?php require_once($err_path . '/views/header.view.php');?>

<div class="error_div">
	<h2>An Error has occured.</h2>
	<ul>
		<li><?php HH::_e( $_GET['error'] ); ?></li>
	</ul>

</div>


<?php require_once($err_path . '/views/footer.view.php');?>