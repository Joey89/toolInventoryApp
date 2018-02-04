<?php 
$create_path_idx = realpath(dirname(__FILE__) . '/..');
require_once($create_path_idx . '/vendor/autoload.php');

use \HT\DB;
use \HT\Helpers as HH;

$db = new DB();


require_once($create_path_idx . '/views/header.view.php');


$tools = $db->selectRaw('SELECT * FROM tools ORDER BY name ASC');
$brands = $db->selectRaw('SELECT * FROM toolsbrands ORDER BY brand ASC');
$conditions = $db->selectRaw('SELECT * FROM toolscondition');
$types = $db->setTable('toolstypes')->select('*');
$sold = $db->setTable('toolsdescription')->select('sold');

?>

<h2 class="search_text">Create Tool Data</h2>
<form method="POST" action="../create/create.php" class="create_tools">
	<label for="tool_option">Choose Tool:</label>

	<input type="checkbox" id="new_tool"><span class="description">Select if tool not found, to create new tool.</span>

	<span id="tool_from_scratch"></span>

	<select name="tool_option" id="tool_option">
	<?php foreach ($tools as $key => $tool) : ?>
		<?php if($tool['name'] != ""): ?>
		<option value="<?php HH::_e($tool['id']); ?>"><?php HH::_e($tool['name']); ?></option>
		<?php endif; ?>
	<?php endforeach; ?>
	</select>
	
	

	<label for="brand_option">Choose Brand:</label>
		<input type="checkbox" id="brand_tool"><span class="description">Select if brand not found, to create new brand.</span>
		<span id="brand_from_scratch"></span>
	<select name="brand_option" id="brand_option">
	<?php foreach ($brands as $key => $brand) : ?>
		<option value="<?php HH::_e($brand['id']); ?>"><?php HH::_e($brand['brand']); ?></option>
	<?php endforeach; ?>
	</select>
	

	<label for="type_option">Choose Type:</label>
	<select name="type_option" id="type_option">
	<?php foreach ($types as $key => $type) : ?>
		<option value="<?php HH::_e($type['id']); ?>"><?php HH::_e($type['type']); ?></option>
	<?php endforeach; ?>
	</select>

	<label for="tool_condition">Choose Condtion:</label>
	<select name="tool_condition" id="tool_condition">
	<?php foreach ($conditions as $key => $condition) : ?>
		<option value="<?php HH::_e($condition['id']); ?>"><?php HH::_e($condition['tool_condition']); ?></option>
	<?php endforeach; ?>
	</select>

	
	<label for="tool_description">Description: <span class="description">( Shape the tool is in / other info )</span></label>
	<textarea type="text" name="tool_description" id="tool_description" class="textarea-form-create"></textarea>

	<label for="tool_price">Price: </label>
	<input type="checkbox" name="price_range_max" id="price_range_max"> 
	<span class="description">Range ( Enable Min - Max Prices )</span>

	<input type="number" name="tool_price" id="tool_price" step=".01">
		
	<label for="max_price_range">Max Price:</label>
	<input type="number" name="max_price_range" id="max_price_range" disabled="true">
	
	
	<label for="sold">Sold <span class="description">Mark if already sold (true) or not sold (false)</span></label>
	<select name="sold" id="sold">
		<option value="-1">False</option>
		<option value="1">True</option>
	</select>

	<button type="submit" class="btn btn-primary button_create">Submit</button>
</form>

<?php require_once($create_path_idx . '/views/footer.view.php'); ?>




	