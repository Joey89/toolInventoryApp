<?php 
$create_path = realpath(dirname(__FILE__) . '/..');
require_once($create_path . '/vendor/autoload.php');

use \HT\DB;
use \HT\Helpers as HH;

$db = new DB();
$path_returns = '../../../../Toolapp/';

function sendJoesError($error){
	header('Location: ../../../../../Toolapp/views/error.view.php?error='.$error);
	exit();
}
function chexRegex($string){
		//Regex Checks on all input forms
		//combine vars into array for testing;
		$stringRegex = '/(<[^>]*script|[|*{}[\]\0\'\"\b\n\r\t\%\_<>])\Z/i';
		$message = '';
		$string = trim($string);
		if( preg_match_all($stringRegex, $string, $matches) ){
			//match found
			HH::dd($matches, true);
			$error = 'Text input cannot contain certain characters, some include: < > | [ ] { } * % ' . var_dump($matches);
			sendJoesError($error);
		}
		return true;
	}

function checkSaveReturnToggledOptions($data, $typeid, $oldId, $db, $db_opt=""){
	if( !empty($data) && isset($data) ){
		$db->setTable('tools');

		//check if record exists;
		$records = $db->select('name');
		foreach ($records as $key => $record) {
			# code...
			if( $data == strtolower($record["name"]) ){
				sendJoesError("Item Name Already Exists");
			}
		}
		if($db_opt==="brand"){
			//Store new tool into database and retrieve its id
			$db->setSQL("INSERT INTO `toolsbrands` VALUES('', :name)");
			$db->bind(':name',$data);
			$db->sqlExecute();
			//set toolid to this new items id;
			$dbr = $db->setTable('toolsbrands')->select('*','', '', '', 'ORDER BY id DESC LIMIT 1');
			
			$dbr = $dbr[0];
			return $dbr['id'];
		}

		//Store new tool into database and retrieve its id
		$db->setSQL("INSERT INTO `tools` VALUES('', :name, :typeid)");
		$db->bind(':name',$data);
		$db->bind(':typeid',$typeid);
		$db->sqlExecute();
		//set toolid to this new items id;
		$dbr = $db->select('*','', '', '', 'ORDER BY id DESC LIMIT 1');
		
		$dbr = $dbr[0];
		return $dbr['id'];
	}else{
		return $oldId;
	}
}
//HH::dd($_POST['sold'],true);
if(!empty($_POST['tool_option']) && !empty($_POST['brand_option']) && !empty($_POST['type_option']) && !empty($_POST['tool_condition']) && !empty($_POST['tool_description']) && !empty($_POST['tool_price']) && !empty($_POST['sold'])){
	if(isset($_POST['tool_option']) && isset($_POST['brand_option']) && isset($_POST['type_option']) && isset($_POST['tool_condition']) && isset($_POST['tool_description']) && isset($_POST['tool_price']) && isset($_POST['sold'])){
		//max price range on own, because it will vary
		if(isset($_POST['max_price_range']) && !empty($_POST['max_price_range'])){
			$max_price_range = $_POST['max_price_range'];
		}else{
			$max_price_range = 0;
		}
	//Save To DB
	$toolid = $_POST["tool_option"];
	$brandid = $_POST["brand_option"];
	$tool_description = $_POST["tool_description"];;
	$tool_condition = $_POST["tool_condition"];
	$tool_price = $_POST["tool_price"];
	$sold = $_POST['sold'];
	$typeid = $_POST['type_option'];
	$date_added = date('Y-m-d');
	$date_sold = '';

	
	chexRegex($_POST['tool_description']);


	if(!empty($_POST['tool_option_new']) && isset($_POST['tool_option_new'])){
			chexRegex($_POST['tool_option_new']);
        $toolid = checkSaveReturnToggledOptions($_POST['tool_option_new'], $typeid, $toolid, $db);
    }
	if(!empty($_POST['brand_option_new']) && isset($_POST['brand_option_new'])){
			chexRegex($_POST['brand_option_new']);
    	$brandid = checkSaveReturnToggledOptions($_POST['brand_option_new'], $typeid, $brandid, $db, "brand");
    }

	
		if($sold === '1'){
			$date_sold = date('Y-m-d');
		}
		$sql = 'INSERT INTO toolsdescription VALUES("", :toolid, :brandid, :tool_description, :tool_condition, :toolPrice, :sold, :typeid, :date_added, :date_sold, :max_price)';
		$db->setSQL($sql);
		$db->bind(':toolid', $toolid);
		$db->bind(':brandid', $brandid);
		$db->bind(':tool_description', $tool_description);
		$db->bind(':tool_condition', $tool_condition);
		$db->bind(':toolPrice', $tool_price);
		$db->bind(':typeid', $typeid);
		$db->bind(':sold', $sold);
		$db->bind(':date_added', $date_added);
		$db->bind(':date_sold', $date_sold);
		$db->bind(':max_price', $max_price_range);
		//HH::dd($db->sqlExecute(), true);
		if(!$db->sqlExecute()){
			$error = 'Data Not Saving';
			sendJoesError($error);
		}

		//$db->insertRaw("INSERT INTO toolsdescription VALUES('', $toolid, $brandid, $tool_description, $tool_condition, $tool_price, $sold, $typeid)");
		//if(!$db->sqlExecute()){
			//throw new Exception("Error Processing Request", 1);
			
		//}
		header('Location: ' . $path_returns . '/?message=Create Tool Successful.');

	//Errors Below
	}else{
		$error = 'Fields not set Properly.';
		sendJoesError($error);
	}
}else{
	$error = 'No fields can be left empty. Please try again.';
	sendJoesError($error);
}

?>