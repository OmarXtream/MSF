<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();


if (getenv('HTTP_CLIENT_IP')){
	$ip = getenv('HTTP_CLIENT_IP');
}else if(getenv('HTTP_X_FORWARDED_FOR')){
	$ip = getenv('HTTP_X_FORWARDED_FOR');
}else if(getenv('HTTP_X_FORWARDED')){
	$ip = getenv('HTTP_X_FORWARDED');
}else if(getenv('HTTP_FORWARDED_FOR')){
	$ip = getenv('HTTP_FORWARDED_FOR');
}else if(getenv('HTTP_FORWARDED')){
   $ip = getenv('HTTP_FORWARDED');
}else if(getenv('REMOTE_ADDR')){
	$ip = getenv('REMOTE_ADDR');
}

include 'functions.php';



class DB
{
  private $db_host = 'localhost';
  private $db_port = 3306;
  private $db_user = "root";
  private $db_pass = 'qvaGN6vy9EaZMw5l';
  private $db_name = 'MSF';
  private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4");
  protected $conn;

  public function openConnection(){

    $this->conn = null;

    try{
    $this->conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_pass, $this->options);

    }catch(PDOException $exception){
		die("Error [DB].");
    }
    return $this->conn;
  }
  public function closeConnection() {
    $this->conn = null;
  }
}
$database = new DB();

?>