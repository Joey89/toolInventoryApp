<?php 
////
// @package toolapp/update
////

$update_path = realpath(dirname(__FILE__) . '/..');
require_once($update_path . '/vendor/autoload.php');

use \HT\DB;
use \HT\Helpers as HH;

$db = new DB();


require($update_path . '/views/header.view.php');
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
require($update_path .'/update/update.view.php');
?>

<script type="text/javascript" src="../src/js/tool-search.js"></script>
<script type="text/javascript">
	initSearch("../inc/toolList.php", 'update.php');
</script>

<?php require($update_path . '/views/footer.view.php'); ?>

