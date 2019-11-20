<?php
//declare the connection class
class DBconnect{
  //declare the connection variable
  private $conn;
	public function connect(){
	   require_once("Config.php");
	   $this->conn = new mysqli(DBHOST,DBUSER,DBPASS,DB);
	   if(!$this->conn){
	      echo "could not connect to the database";
	   }
	   else{
	    return $this->conn;
	   }
	}
}
?>
