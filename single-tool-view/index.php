<?php 
$single_path = realpath(dirname(__FILE__) . '/..');
require_once($single_path . '/vendor/autoload.php');

use \HT\DB;
use \HT\Helpers as HH;

$db = new DB();

function sendJoesError($error){
	header('Location: ../../../../../Toolapp/views/error.view.php?error='.$error);
	exit();
}?>

<?php require($single_path . "/views/header.view.php");?>

<?php
if(isset($_POST['tool_id']) && !empty($_POST['tool_id'])){
	$id = $_POST['tool_id'];

	$sql = 'SELECT `date_added`, `date_sold`, `tools_id`, `brand_id`, `description`, `tool_condition_id`, `price`, `max_price`, `sold`, `type_id`, `tools`.`id`, `tools`.`name`, `tools`.`type`, `toolsbrands`.`id`, `toolsbrands`.`brand`, `toolstypes`.`id`, `toolstypes`.`type`, `toolscondition`.`tool_condition`, `toolscondition`.`condition_description`
		FROM `toolsdescription`
		INNER JOIN `tools` ON `tools_id` = `tools`.`id`
		INNER JOIN `toolsbrands` ON `brand_id` = `toolsbrands`.`id`
		INNER JOIN `toolstypes` ON `type_id` = `toolstypes`.`id`
		INNER JOIN `toolscondition` ON `tool_condition_id` = `toolscondition`.`id`
		WHERE `toolsdescription`.`id`=:id';
	$db->setTable('toolsdescription')->setSQL($sql);
	$db->bind(':id', $id);
	$db->sqlExecute();
	$toolDesc = $db->getResults();
	//HH::dd($toolDesc, true);
	?>
	<div class="secected_tool_single" style="padding: 20px;">
		<h2>Selected Tool info:</h2>
		<table border="1" class="table_of_tools">
			<thead>
				<th>Tool</th>
				<th>Brand</th>
				<th>Type</th>
				<th>Description</th>
				<th>Condition</th>
				<th>Price</th>
			</thead>
		<?php foreach($toolDesc as $k => $selectedTool): ?>
			<?php 
				if($selectedTool['max_price'] === '0'){
					$toolMaxPrice = '';
				}else{
					$toolMaxPrice = '- ' .  $selectedTool['max_price'];
				}
			 ?>
			<td><?php hh::_e($selectedTool['name']); ?></td>
			<td><?php hh::_e($selectedTool['brand']); ?></td>
			<td><?php hh::_e($selectedTool['type']); ?></td>
			<td><?php hh::_e($selectedTool['description']); ?></td>
			<td><?php hh::_e($selectedTool['tool_condition']); ?></td>
			<td><?php hh::_e($selectedTool['price'] . $toolMaxPrice); ?></td>
		<?php endforeach; ?>
		</table>
	</div>
<?php
}else{
	sendJoesError('Fields not filled out correctly.');
}
?>
<?php if(isset($_GET['message'])): ?>
	<div id="tool_container">
	<div class="tool_message_flash">
		<?php HH::_e($_GET['message']); ?>
	</div>
	<div id="tool_message_flash_remove"></div>
	</div>

<?php endif; ?>
<!--
<?php //require("./views/index.view.php");?>

<script src="./src/js/tool-search.js"></script>
<script type="text/javascript">
	//initSearch("./inc/toolList.php", 'single-tool-view.php');
</script>
-->

<span id="dblclickformcontainer"></span>
<?php require($single_path . '/views/footer.view.php'); ?>