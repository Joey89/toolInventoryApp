<?php namespace HT;

$delete_path_del = realpath(dirname(__FILE__) . '/..');
require $delete_path_del . '/classes/dbconfig.php';
//http://megatvbox.eu/repo
class DB{
	private $conn;
	private $stmt;
	private $error;
	private $table;

	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	public $errorPage = __DIR__ . '/views/error.view.html';


	public function __construct(){
		try {
			$this->conn = new \PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
		} catch (PDOException $e) {
			//Return Error view
			$this->error = 'Error connecting to the database. Please wait a while and try again.';
			$error =  $this->error;
			Header('Location: ' . $this->errorPage . '?error='.$error);

		}
	}
	//Set Table
	public function setTable($table){
		$this->table = $table;
		return $this;
	}
	//Bind params for PDO 
	public function bind($param, $bindVar){
		$this->stmt->bindParam($param, $bindVar);
	}
	//
	public function setSQL($sql){
		$this->stmt = $this->conn->prepare($sql);
	}
	//Execute Current Query
	public function sqlExecute(){
		if($this->stmt->execute()){
			return true;
		}
		return false;
	}

	public function getResults(){
		return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function select($selector='*', $operator='=', $val='', $compareVal='', $order=''){
		if(empty($val) || empty($compareVal)){
			$sql = 'SELECT ' . $selector . ' FROM ' . $this->table;
		}else{
				$where = ' WHERE ' . $val . ' ' . $operator . ' ' . $compareVal;
				$sql = 'SELECT ' . $selector . ' FROM ' . $this->table . ' ' .  $where;
		}
		$sql .= ' ' . $order;
		try{
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			//var_dump($result);
		}catch(PDOException $e){
			$this->error = 'Having trouble selecting results from database. ' .  $e->getMessage();
			Header('Location: ' . './views/error.view.php?error='.$this->error);
		}
		return $result;	
	}

	public function selectRaw($sql){
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
	}

	public function insertRaw($sql){
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
	}

	public function deleteEntry($table, $id){
		try{
			$sql = "DELETE FROM $table WHERE id=$id";
			$this->conn->exec($sql);
		}catch(PDOException $e){
			$error = $e->getMesasge();
			return $error;
		}
		return true;
	}

}
?>