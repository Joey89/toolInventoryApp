<?php
$list_path = realpath(dirname(__FILE__) . '/..');
require  $list_path . '/vendor/autoload.php';
use \HT\DB;
use \HT\Helpers as HH;

$db = new DB();


$sql = 'SELECT `toolsdescription`.`id`,`toolsdescription`.`date_added`,`toolsdescription`.`date_sold`, `description`, `tool_condition`, `price`, `sold`, `max_price`, `tools`.`name`, `tools`.`type`, `toolsbrands`.`brand`, `toolstypes`.`type`, `toolscondition`.`tool_condition`, `toolscondition`.`condition_description`
	FROM `toolsdescription`
	INNER JOIN `tools` ON `tools_id` = `tools`.`id`
	INNER JOIN `toolsbrands` ON `brand_id` = `toolsbrands`.`id`
	INNER JOIN `toolstypes` ON `type_id` = `toolstypes`.`id`
	INNER JOIN `toolscondition` ON `tool_condition_id` = `toolscondition`.`id`';


$result = json_encode($db->setTable('tools')->selectRaw($sql));

echo $result;
