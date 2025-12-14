<!DOCTYPE html>
<html>
<head>
    <title>Sri Lanka Provinces</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">

<?php include 'db.php'; ?>

<div class="container mt-5">

    <h2 class="text-center mb-2">Provinces of Sri Lanka</h2>

    <!-- Add City Button at Top -->
    <div class="d-flex justify-content-end mb-4">
        <a href="add_city.php" class="btn btn-success">
            ➕ Add New City
        </a>
    </div>

    <div class="accordion" id="provinceAccordion">

        <?php
        $provinces = $conn->query("SELECT * FROM provinces");
        $pIndex = 0;

        while ($province = $provinces->fetch_assoc()) {
            $pIndex++;
        ?>
            <div class="accordion-item mb-3">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#province<?= $pIndex ?>">
                        <?= $province['name'] ?>
                    </button>
                </h2>

                <div id="province<?= $pIndex ?>" class="accordion-collapse collapse">
                    <div class="accordion-body">

                        <?php
                        $cities = $conn->query("
                            SELECT c.*, d.name AS district_name
                            FROM cities c
                            LEFT JOIN districts d ON c.district_id = d.id
                            WHERE c.province_id = {$province['id']}
                        ");

                        if ($cities->num_rows > 0) {
                            while ($city = $cities->fetch_assoc()) {
                        ?>
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">

                                        <h5 class="card-title mb-1">
                                            <?= $city['name'] ?>
                                        </h5>

                                        <span class="badge bg-secondary mb-2">
                                            District: <?= $city['district_name'] ?? 'N/A' ?>
                                        </span>

                                        <p class="card-text text-muted mt-2">
                                            <?= $city['description'] ?>
                                        </p>

                                        <button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#city<?= $city['id'] ?>">
                                            View Details
                                        </button>

                                        <div class="collapse mt-3" id="city<?= $city['id'] ?>">
                                            <p><strong>Key Activities:</strong><br><?= $city['key_activities'] ?></p>
                                            <p><strong>Highlights:</strong><br><?= $city['highlights'] ?></p>

                                            <a href="edit_city.php?id=<?= $city['id'] ?>"
                                               class="btn btn-sm btn-warning">Edit</a>

                                            <a href="delete_city.php?id=<?= $city['id'] ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure?')">
                                               Delete
                                            </a>
                                        </div>

                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p class='text-muted'>No cities added yet.</p>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>

</body>
</html>
