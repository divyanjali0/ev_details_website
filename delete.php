<?php
include 'db.php';

if (!isset($_GET['type'], $_GET['id'])) {
    die("Invalid request");
}

$type = $_GET['type'];
$id   = (int) $_GET['id'];

switch ($type) {

    case 'province':
        // Optional: delete related districts & cities first
        $conn->query("DELETE FROM cities WHERE province_id = $id");
        $conn->query("DELETE FROM districts WHERE province_id = $id");
        $stmt = $conn->prepare("DELETE FROM provinces WHERE id = ?");
        break;

    case 'district':
        // Optional: delete related cities first
        $conn->query("DELETE FROM cities WHERE district_id = $id");
        $stmt = $conn->prepare("DELETE FROM districts WHERE id = ?");
        break;

    case 'city':
        $stmt = $conn->prepare("DELETE FROM cities WHERE id = ?");
        break;

    default:
        die("Invalid delete type");
}

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
