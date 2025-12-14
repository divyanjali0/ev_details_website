<?php
include 'db.php';
$id = $_GET['id'];

$city = $conn->query("SELECT * FROM cities WHERE id=$id")->fetch_assoc();
?>

<form method="POST">
    <input type="text" name="name" value="<?= $city['name'] ?>"><br><br>
    <textarea name="description"><?= $city['description'] ?></textarea><br><br>
    <textarea name="key_activities"><?= $city['key_activities'] ?></textarea><br><br>
    <textarea name="highlights"><?= $city['highlights'] ?></textarea><br><br>

    <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    $stmt = $conn->prepare(
        "UPDATE cities SET name=?, description=?, key_activities=?, highlights=? WHERE id=?"
    );

    $stmt->bind_param(
        "ssssi",
        $_POST['name'],
        $_POST['description'],
        $_POST['key_activities'],
        $_POST['highlights'],
        $id
    );

    $stmt->execute();
    header("Location: index.php");
}
?>
