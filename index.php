<?php include 'db.php'; ?>

<h2>Provinces of Sri Lanka</h2>

<?php
$provinces = $conn->query("SELECT * FROM provinces");

while ($province = $provinces->fetch_assoc()) {
    echo "<h3>{$province['name']}</h3>";

    $cities = $conn->query(
        "SELECT * FROM cities WHERE province_id = {$province['id']}"
    );

    if ($cities->num_rows > 0) {
        while ($city = $cities->fetch_assoc()) {
            echo "<p>
                <b>{$city['name']}</b><br>
                {$city['description']}<br>
                <i>Activities:</i> {$city['key_activities']}<br>
                <i>Highlights:</i> {$city['highlights']}<br>
                <a href='edit_city.php?id={$city['id']}'>Edit</a> |
                <a href='delete_city.php?id={$city['id']}'>Delete</a>
            </p>";
        }
    } else {
        echo "<p>No cities added yet.</p>";
    }
}
?>

<a href="add_city.php">➕ Add New City</a>
