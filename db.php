<?php
$conn = new mysqli("localhost", "root", "", "explore_vacations");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
