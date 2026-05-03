<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host     = "localhost";
$user     = "root";
$password = "";        // ← XAMPP default is empty, WAMP may differ
$database = "student_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>