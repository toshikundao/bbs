<?php
$username = "nakatsuka";
$password = "nakatsuka";
$host     = "localhost";
$database = "nakatsuka";

$dsn = "mysql:host=$host;dbname=$database;charset=utf8";

try {
  $db = new PDO($dsn, $username, $password); 
} catch (PDOException $e) {
  print('Connection failed:'.$e->getMessage());
  die();
}