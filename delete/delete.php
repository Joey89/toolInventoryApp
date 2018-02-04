<?php 
$delete_path_del = realpath(dirname(__FILE__) . '/..');
require_once($delete_path_del . '/vendor/autoload.php');

use \HT\Helpers as HH;
use \HT\DB;

$db = new DB();

function sendJoesError($error){
	header('Location: ../../../../../Toolapp/views/error.view.php?error='.$error);
	exit();
}

if(!empty($_POST['tool_id'])){
	if(isset($_POST['tool_id'])){
		if( $db->deleteEntry('toolsdescription', $_POST['tool_id']) ){
			//successfully deleted
			$message='You have DELETED a tool.';
			Header('Location: ' . '../../../../Toolapp/delete?message='.$message);
		}
	}else{
		$error = 'Trouble deleting record. Id isnt set.';
		sendJoesError($error);
	}
}else{
	$error = 'Trouble deleting record. Id is empty.';
	sendJoesError($error);
}

?>