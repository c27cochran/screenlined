<?php 

// Stg
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'root');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'screenlined');

// GoDaddy prod
// DEFINE ('DB_USER', 'c27cochran');
// DEFINE ('DB_PASSWORD', 'Screenlined1');
// DEFINE ('DB_HOST', 'localhost');
// DEFINE ('DB_NAME', 'screenlined');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
}

?>
