<?php
include 'db.php';

if (isset($_GET['province_id'])) {
    $province_id = (int) $_GET['province_id'];

    $result = $conn->query(
        "SELECT id, name FROM districts WHERE province_id = $province_id"
    );

    echo '<option value="">Select District</option>';

    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
}
