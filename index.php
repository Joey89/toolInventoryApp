<?php 
$path = __DIR__;
require_once $path . '/vendor/autoload.php';

use \HT\DB;
use \HT\Helpers as HH;
use \HT\Config;

require('./views/header.view.php');

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

require("./views/index.view.php");
?>

<script src="./src/js/tool-search.js"></script>
<script type="text/javascript">
	initSearch("./inc/toolList.php", 'single-tool-view/index.php');
</script>


<span id="dblclickformcontainer"></span>
<?php require('./views/footer.view.php'); ?>