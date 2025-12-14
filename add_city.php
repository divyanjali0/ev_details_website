<?php include 'db.php'; ?>

<form method="POST">
    <!-- Province Dropdown -->
    <label>Province:</label>
    <select name="province_id">
        <option value="">Select Province</option>
        <?php
        // Fetch all provinces from the provinces table
        $result = $conn->query("SELECT * FROM provinces");
        while ($row = $result->fetch_assoc()) {
            // Display each province as an option
            echo "<option value='{$row['id']}'";
            if (isset($_POST['province_id']) && $_POST['province_id'] == $row['id']) {
                echo " selected";
            }
            echo ">{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    <!-- District Dropdown (All districts, no filtering) -->
    <label>District:</label>
    <select name="district_id">
        <option value="">Select District</option>
        <?php
        // Fetch all districts from the districts table
        $district_result = $conn->query("SELECT * FROM districts");
        while ($row = $district_result->fetch_assoc()) {
            // Display each district as an option
            echo "<option value='{$row['id']}'";
            if (isset($_POST['district_id']) && $_POST['district_id'] == $row['id']) {
                echo " selected";
            }
            echo ">{$row['name']}</option>";
        }
        ?>
    </select><br><br>

    <!-- City Name -->
    <input type="text" name="name" placeholder="City Name" required><br><br>

    <!-- Description -->
    <textarea name="description" placeholder="Description"></textarea><br><br>

    <!-- Key Activities -->
    <textarea name="key_activities" placeholder="Key Activities"></textarea><br><br>

    <!-- City Highlights -->
    <textarea name="highlights" placeholder="City Highlights"></textarea><br><br>

    <!-- Save Button -->
    <button type="submit" name="save">Save</button>
</form>

<?php
if (isset($_POST['save'])) {
    // Prepare and execute the insert query with province_id, district_id, and other fields
    $stmt = $conn->prepare(
        "INSERT INTO cities (province_id, district_id, name, description, key_activities, highlights)
         VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "iissss",
        $_POST['province_id'],
        $_POST['district_id'],
        $_POST['name'],
        $_POST['description'],
        $_POST['key_activities'],
        $_POST['highlights']
    );

    $stmt->execute();
    header("Location: index.php"); // Redirect to index after successful insert
}
?>
