<?php
$servername = "localhost";
$username = "stephany";
$password = "12345";
$dbname = "crud";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>