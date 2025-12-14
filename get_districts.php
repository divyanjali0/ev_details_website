<?php
// get_districts.php
include 'db.php';

if (isset($_GET['province_id'])) {
    $province_id = $_GET['province_id'];
    $res = $conn->query("SELECT * FROM districts WHERE province_id = {$province_id}");
    while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
}
?>
