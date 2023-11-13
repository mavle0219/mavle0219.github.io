<?php
try {

$db_name = "mysql:host=localhost;dbname=cap";
$username = "root";
$password = "";

$conn = new PDO($db_name, $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $exc) {
    echo $exc->getMessage();
}
?>