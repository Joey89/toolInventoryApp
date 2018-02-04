<?php 

interface userInterface{
	public function getAccountName();
	public function getEmail();
}

class Test{

	public function addName(userInterface $user){
		echo $user->getAccountName();
	}
}

class User implements userInterface{
	private $account_name;
	private $email;
	private $password;

	function __construct($account_name, $email, $password)
	{
		$this->account_name = $account_name;
		$this->email = $email;
		$this->password = $password;
	}

	public function getAccountName(){
		return $this->account_name;
	}

	public function getEmail(){
		return $this->email;
	}
}
?>