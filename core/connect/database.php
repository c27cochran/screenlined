<?php 
# We are storing the information in this config array that will be required to connect to the database.
//stg
$config = array(
	'host'		=> 'localhost',
	'username'	=> 'root',
	'password'	=> 'root',
	'dbname' 	=> 'screenlined'
);

// GoDaddy prod
// $config = array(
// 	'host'		=> 'localhost',
// 	'username'	=> 'c27cochran',
// 	'password'	=> 'Screenlined1',
// 	'dbname' 	=> 'screenlined'
// );

// c27 prod
// $config = array(
// 	'host'		=> 'db508363630.db.1and1.com',
// 	'username'	=> 'dbo508363630',
// 	'password'	=> 'cjc44288',
// 	'dbname' 	=> 'db508363630'
// );

#connecting to the database by supplying required parameters
$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
 
#Setting the error mode of our db object, which is very important for debugging.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>