<?php
$servername = "localhost";
$username = "admin";
$password = "12345";

try {
  $conn = new PDO("mysql:host=$servername;dbname=db_hhi", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
