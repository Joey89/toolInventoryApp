<?php 
$update_path_sub = realpath(dirname(__FILE__) . '/..');
require_once($update_path_sub . '/vendor/autoload.php');

use \HT\DB;
use \HT\Helpers as HH;
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

	//HH::dd($_POST['sold'], true);
	if(!empty($_POST['tool_option']) && !empty($_POST['brand_option']) && !empty($_POST['type_option']) && !empty($_POST['tool_condition']) && !empty($_POST['tool_description']) && !empty($_POST['tool_price']) && !empty($_POST['tool_id']) && !empty($_POST['sold']) && !empty( $_POST['date_added'] )){
		if(isset($_POST['tool_option']) && isset($_POST['brand_option']) && isset($_POST['type_option']) && isset($_POST['tool_condition']) && isset($_POST['tool_description']) && isset($_POST['tool_price']) && isset($_POST['tool_id']) && isset($_POST['sold']) && isset( $_POST['date_added'] ) ){

			if( isset($_POST['max_price_range']) && !empty($_POST['max_price_range']) ){
				$max_price_range = $_POST['max_price_range'];
			}	else {
			    $max_price_range = 0;
				//HH::dd('NOT SETTING FIELDS', true);
			}

			if( isset($_POST['date_sold']) && !empty($_POST['date_sold']) ){
				$date_sold = $_POST['date_sold'];
			}	else{
			    $date_sold = '';
				//HH::dd('NOT SETTING FIELDS', true);
			}


			//Vars to enter into db
			$id = $_POST['tool_id'];
			$tool_option = $_POST['tool_option'];
			$brand_option = $_POST['brand_option'];
			$type_option = $_POST['type_option'];
			$tool_condition = $_POST['tool_condition'];
			$tool_description = $_POST['tool_description'];
			$tool_price = $_POST['tool_price'];
			$sold =  $_POST['sold'];
			$date_added = $_POST['date_added'];

			chexRegex($tool_description);
			//HH::dd('ID: ' . $id . ' ' . 	$tool_option . ' ' . $brand_option . ' ' . $type_option . ' ' . $tool_condition . ' ' . $tool_description . ' ' .	$tool_price . ' ' . $sold . ' ' . $date_added . ' ' . $date_sold . ' ' . $max_price_range, true);
			//Save updated data to DB
			try{
		//	HH::dd('MAX: ' . $max_price_range, 'DATE SOLD: ' . $date_sold, true);
				$db = new DB();
				$sql = 'UPDATE toolsdescription
								SET price = :price,
								tools_id = :tool_option,
								brand_id = :brand_option,
								description = :tool_description,
								tool_condition_id = :tool_condition,
								type_id = :type_option,
								sold = :sold,
								max_price = :max_price_range,
								date_added = :date_added,
								date_sold = :date_sold
								WHERE id= :id ';
				$db->setSQL($sql);
				$db->bind(':tool_option', $tool_option);
				$db->bind(':brand_option', $brand_option);
				$db->bind(':tool_description', $tool_description);
				$db->bind(':tool_condition', $tool_condition);
				$db->bind(':price', $tool_price);
				$db->bind(':id', $id);
				$db->bind(':sold', $sold);
				$db->bind(':type_option', $type_option);
				$db->bind(':date_added', $date_added);
				$db->bind(':date_sold', $date_sold);
				$db->bind(':max_price_range', $max_price_range);
				$db->sqlExecute();
			}catch(PDOException $e){
				echo 'broke';
				HH::dd($e->getMessage(), true);
			}

			Header('Location: ' . '../../../../../Toolapp/update/?message=Tool Successfully Updated');

		}else{
			$error = 'Error Updating DB, a field is not set';
			sendJoesError($error);
		}
	}else{
		$error = 'Error Updating DB, a field is empty';
		sendJoesError($error);
	}
?>