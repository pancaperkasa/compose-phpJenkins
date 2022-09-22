<?php
/**
 * using mysqli_connect for database connection
 */
 
$databaseHost = 'mysql';
$databaseName = 'crud_db';
$databaseUsername = 'root';
$databasePassword = 'secret';
 
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
 

?>