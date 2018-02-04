<?php 
$update_path_up = realpath(dirname(__FILE__) . '/..');
require_once($update_path_up . '/vendor/autoload.php');

use \HT\DB;
use \HT\Helpers as HH;
$db = new DB();
$tools = $db->setTable('tools')->select('*');
$brands = $db->setTable('toolsbrands')->select('*');
$types = $db->setTable('toolstypes')->select('*');
$conditions = $db->setTable('toolscondition')->select('*');
require($update_path_up . '/views/header.view.php');

//HH::dd($_POST['tool_id'], true);
if(!empty($_POST['tool_id'])){
	if(isset($_POST['tool_id'])){
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




		<h2>Update Tool Data</h2>
		<form method="POST" action="update-submit.php" class="create_tools">
			<label for="tool_option">Choose Tool:</label>
			<select name="tool_option" id="tool_option">
				<option selected="selected" value="<?php HH::_e($selectedTool['tools_id']); ?>">
					<?php hh::_e($selectedTool['name']); ?>
				</option>
			<?php foreach ($tools as $key => $tool) : ?>
				<option value="<?php HH::_e($tool['id']); ?>"><?php HH::_e($tool['name']); ?></option>
			<?php endforeach; ?>
			</select>

			<label for="brand_option">Choose Brand:</label>
			<select name="brand_option" id="brand_option">
				<option selected="selected" value="<?php HH::_e($selectedTool['brand_id']); ?>">
					<?php hh::_e($selectedTool['brand']); ?>
				</option>
			<?php foreach ($brands as $key => $brand) : ?>
				<option value="<?php HH::_e($brand['id']); ?>"><?php HH::_e($brand['brand']); ?></option>
			<?php endforeach; ?>
			</select>
			
			<label for="type_option">Choose Type:</label>
			<select name="type_option" id="type_option">
				<option selected="selected" value="<?php HH::_e($selectedTool['type_id']); ?>">
					<?php hh::_e($selectedTool['type']); ?>
				</option>
			<?php foreach ($types as $key => $type) : ?>
				<option value="<?php HH::_e($type['id']); ?>"><?php HH::_e($type['type']); ?></option>
			<?php endforeach; ?>
			</select>
			
			<label for="tool_condition">Choose Condtion:</label>
			<select name="tool_condition" id="tool_condition">
				<option selected="selected" value="<?php HH::_e($selectedTool['type_id']); ?>">
					<?php hh::_e($selectedTool['tool_condition']); ?>
				</option>
			<?php foreach ($conditions as $key => $condition) : ?>
				<option value="<?php HH::_e($condition['id']); ?>"><?php HH::_e($condition['tool_condition']); ?></option>
			<?php endforeach; ?>
			</select>
			
			<label for="tool_description">Description: </label>
			<textarea name="tool_description" id="tool_description"><?php HH::_e($selectedTool['description']); ?></textarea>
			
			<input type="hidden" name="tool_id" value="<?php HH::_e($id); ?>" />
			
			<label for="tool_price">Price: </label>
			<input type="checkbox" id="price_range_max"> 
			<span class="description">Range ( Enable Min - Max Prices )</span>

			<input type="number" name="tool_price" id="tool_price" value="<?php HH::_e($selectedTool['price']); ?>">

			<label for="max_price_range">Max Price: </label>
			<?php if( $selectedTool['max_price'] !== '0' ) : ?>
				<input type="number" name="max_price_range" id="max_price_range" value="<?php HH::_e($selectedTool['max_price']); ?>">
			<?php else: ?>
				<input type="number" name="max_price_range" id="max_price_range" value="<?php HH::_e($selectedTool['max_price']); ?>" disabled="true">
			<?php endif; ?>



			<label for="sold">Sold <span class="description">Mark if already sold (true) or not sold (false)</span></label>
			<select name="sold" id="sold">
					<?php
					//echo $selectedTool['sold'] ;
						if($selectedTool['sold'] == '1'){
							$toolBool = 'True';
							$toolCheck = true;
						}else{
							$toolBool = 'False';
							$toolCheck = false;
						}
				?>
				<option selected="selected" value="<?php HH::_e($selectedTool['sold']); ?>">
					<?php HH::_e($toolBool); ?>
				</option>
				<option value="-1">False</option>
				<option value="1">True</option>
			</select>

			<label for="date_added">Date Added</label>
			<input type="date" name="date_added" id="date_added" value="<?php HH::_e($selectedTool['date_added']); ?>">
			
			<?php if($toolCheck): ?>
				<label for="date_sold">Date Sold</label>
				<input type="date" name="date_sold" id="date_sold" value="<?php HH::_e($selectedTool['date_sold']); ?>">
			<?php else: ?>
				<input type="hidden" name="date_sold" id="date_sold" value="<?php HH::_e($selectedTool['date_sold']); ?>">
			<?php endif; ?>
			<br>
			<button type="submit" class="btn btn-primary button_create">Submit</button>
		</form>

		<?php
	}else{
		//error
		echo 'Errors its id is not set';
	}
}else{
	//Error 
	echo 'Error its id is empty';
}


require($update_path_up . '/views/footer.view.php');
 ?>
