<?php

class SqliResult {
	protected $source = null;
	public $num_rows = 0;
	
	public function __construct($re){
		$this->source = $re;
		$this->num_rows = odbc_num_rows($num_rows);
	}
	
	public function fetch_assoc(){
		return odbc_fetch_array($this->source);
	}
}

class SqliWrapper {

	protected $connect = null;
	
	public $error = "";
	
	public function __construct($server, $user, $pass, $database){
		$this->connect = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", $user, $pass);
	}
	
	public function query($q){
		$this->error = odbc_errormsg($connect);
		return SqliResult(odbc_exec($q));
	}
	
	public function close(){
		odbc_close($this->connect);
	}
}

function dbc(){
	require("dbAccount.php");
	
	// $connect = odbc_connect("Driver={SQL Server};Server=$DB_SERV;Database=$DB_NAME;", $DB_USER, $DB_PASS);
	
	// return $connect;
	
	# please define them

    $dsn = "mysql:dbname=$DB_NAME;host=$DB_SERV;charset=utf8";
    $dbh = new PDO($dsn, $DB_USER, $DB_PASS);

	return $dbh;
	
}

function pw_hash($s){
	return md5("OMG I AM EIGHT'S SALT!!!" . $s);
}

function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}

function logger($v=null){
	ob_start();
	var_dump($v);
	$s = ob_get_clean();
	error_log($s);
}


