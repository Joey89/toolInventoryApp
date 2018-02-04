<?php 
////
// @package toolapp/update
////
$delete_path = realpath(dirname(__FILE__) . '/..');

require_once($delete_path . '/vendor/autoload.php');


use \HT\DB;
use \HT\Helpers as HH;




$db = new DB();
//HH::dd($delete_path, true);
//HH::dd($path);
require_once($delete_path . '/views/header.view.php');
?>
<?php if(isset($_GET['message'])): ?>
	<div id="tool_container">
	<div class="tool_message_flash">
		<?php HH::_e($_GET['message']); ?>
	</div>
	<div id="tool_message_flash_remove"></div>
	</div>

<?php endif; ?>
<?php
require_once($delete_path . '/delete/delete.view.php');
?>

<script type="text/javascript" src="../src/js/tool-search.js"></script>
<script type="text/javascript">
	initSearch("../inc/toolList.php", 'delete.php');
</script>

<?php require_once($delete_path . '/views/footer.view.php'); ?>

