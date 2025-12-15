<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* -------------------- PROVINCE -------------------- */
    if (isset($_POST['provinceId'])) {
        $id   = $_POST['provinceId'];
        $name = $_POST['provinceName'];

        if ($id == '') {
            $stmt = $conn->prepare("INSERT INTO provinces (name) VALUES (?)");
            $stmt->bind_param("s", $name);
        } else {
            $stmt = $conn->prepare("UPDATE provinces SET name=? WHERE id=?");
            $stmt->bind_param("si", $name, $id);
        }

        $stmt->execute();
        header("Location: index.php#provinces");
        exit;
    }

    /* -------------------- DISTRICT -------------------- */
    if (isset($_POST['districtId'])) {
        $id          = $_POST['districtId'];
        $name        = $_POST['districtName'];
        $province_id = $_POST['districtProvince'];

        if ($id == '') {
            $stmt = $conn->prepare("INSERT INTO districts (name, province_id) VALUES (?, ?)");
            $stmt->bind_param("si", $name, $province_id);
        } else {
            $stmt = $conn->prepare("UPDATE districts SET name=?, province_id=? WHERE id=?");
            $stmt->bind_param("sii", $name, $province_id, $id);
        }

        $stmt->execute();
        header("Location: index.php#districts");
        exit;
    }

    // Check if it's a City form submission
    if (isset($_POST['cityId'])) {
        $id          = $_POST['cityId'];
        $province_id = $_POST['cityProvince'];
        $district_id = $_POST['cityDistrict'];
        $description = $_POST['cityDescription'];
        $cityName = $_POST['cityName'];
        
        // Get activities and highlights from the form, as arrays
        $activities  = isset($_POST['cityActivities']) ? $_POST['cityActivities'] : [];
        $highlights  = isset($_POST['cityHighlights']) ? $_POST['cityHighlights'] : [];

        // Convert the arrays into JSON strings
        $activities_json = json_encode($activities);
        $highlights_json = json_encode($highlights);

        if ($province_id == '' || $district_id == '') {
            die("Province and District are required");
        }

        // If ID is empty, we are creating a new city
        if ($id == '') {

            $stmt = $conn->prepare(
                "INSERT INTO cities (province_id, district_id, name, description, key_activities, highlights)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "iissss",
                $province_id,
                $district_id,
                $cityName,
                $description,
                $activities_json,
                $highlights_json
            );

        } else {

            $stmt = $conn->prepare(
                "UPDATE cities
                SET province_id=?, district_id=?, name=?, description=?, key_activities=?, highlights=?
                WHERE id=?"
            );

            $stmt->bind_param(
                "iissssi",
                $province_id,
                $district_id,
                $cityName,
                $description,
                $activities_json,
                $highlights_json,
                $id
            );
        }

        $stmt->execute();
        header("Location: index.php#cities");
        exit;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="d-flex">

<!-- Sidebar -->
<div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
    <h4 class="text-center">Admin</h4>
    <hr class="bg-white">
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link text-white" href="#" data-bs-toggle="tab" data-bs-target="#dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" data-bs-toggle="tab" data-bs-target="#cities">City Details</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" data-bs-toggle="tab" data-bs-target="#provinces">Provinces</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" data-bs-toggle="tab" data-bs-target="#districts">Districts</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="flex-grow-1 p-4">
    <div class="tab-content">

        <!-- Dashboard -->
        <div class="tab-pane fade show active" id="dashboard">
            <h2 class="fw-bold">Welcome!!</h2>
            <p>Select a section from the sidebar to manage Provinces, Districts, and Cities.</p>
        </div>

                <!-- Cities -->
        <div class="tab-pane fade" id="cities">
            <h3>City Details</h3>
            <button class="btn btn-success mb-3" id="addCityBtn">➕ Add Details</button>
            <div class="accordion" id="provinceAccordion">
                <?php
                    $provinces = $conn->query("SELECT * FROM provinces");
                    $pIndex=0;
                    while($province = $provinces->fetch_assoc()){
                        $pIndex++;
                        echo "<div class='accordion-item mb-3'>
                                <h2 class='accordion-header'>
                                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#province$pIndex'>{$province['name']}</button></h2>
                                <div id='province$pIndex' class='accordion-collapse collapse'>
                                <div class='accordion-body d-flex gap-3'>";

                                $cities = $conn->query("SELECT c.*, d.name AS district_name FROM cities c LEFT JOIN districts d ON c.district_id=d.id WHERE c.province_id={$province['id']}");
                                if ($cities->num_rows > 0) {
                                    while ($city = $cities->fetch_assoc()) {
                                        // Decode the JSON data into an array
                                        $activities = json_decode($city['key_activities']);
                                        $highlights = json_decode($city['highlights']);

                                        echo "<div class='col-12 col-md-6 col-lg-3 card mb-2'>
                                                <div class='card-body'>
                                                    <span class='badge bg-secondary'>District: {$city['district_name']}</span>
                                                    <p>{$city['description']}</p>
                                                    <p><strong>Activities:</strong><ul>";
                                        foreach ($activities as $activity) {
                                            echo "<li>{$activity}</li>";
                                        }
                                        echo "</ul></p>
                                            <p><strong>Highlights:</strong><ul>";
                                        foreach ($highlights as $highlight) {
                                            echo "<li>{$highlight}</li>";
                                        }
                                        echo "</ul></p>
                                            <button class='btn btn-sm btn-warning editCityBtn'
                                                    data-id='{$city['id']}'
                                                    data-province='{$city['province_id']}'
                                                    data-district='{$city['district_id']}'
                                                    data-description='".htmlspecialchars($city['description'], ENT_QUOTES)."'
                                                    data-name='".htmlspecialchars($city['name'], ENT_QUOTES)."'
                                                    data-activities='".htmlspecialchars(json_encode($activities), ENT_QUOTES)."'
                                                    data-highlights='".htmlspecialchars(json_encode($highlights), ENT_QUOTES)."'>Edit</button>
                                            </div></div>";
                                    }
                        } else { echo "<p>No cities yet.</p>"; }
                        echo "</div></div></div>";
                    }
                ?>
            </div>
        </div>

        <!-- Provinces -->
        <div class="tab-pane fade" id="provinces">
            <h3>Provinces</h3>
            <button class="btn btn-success mb-3" id="addProvinceBtn">➕ Add Province</button>
            <table class="table table-bordered">
                <thead>
                <tr><th>#</th><th>Name</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php
                $res = $conn->query("SELECT * FROM provinces");
                $i=1;
                while($row=$res->fetch_assoc()){
                    echo "<tr>
                            <td>$i</td>
                            <td>{$row['name']}</td>
                            <td>
                                <button class='btn btn-sm btn-warning editProvinceBtn' data-id='{$row['id']}' data-name='{$row['name']}'>Edit</button>
                            </td>
                          </tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Districts -->
        <div class="tab-pane fade" id="districts">
            <h3>Districts</h3>
            <button class="btn btn-success mb-3" id="addDistrictBtn">➕ Add District</button>
            <table class="table table-bordered">
                <thead>
                <tr><th>#</th><th>Name</th><th>Province</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php
                $res = $conn->query("SELECT d.*, p.name as province_name FROM districts d LEFT JOIN provinces p ON d.province_id=p.id");
                $i=1;
                while($row=$res->fetch_assoc()){
                    echo "<tr>
                            <td>$i</td>
                            <td>{$row['name']}</td>
                            <td>{$row['province_name']}</td>
                            <td>
                                <button class='btn btn-sm btn-warning editDistrictBtn' data-id='{$row['id']}' data-name='{$row['name']}' data-province='{$row['province_id']}'>Edit</button>
                            </td>
                          </tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>



    </div>
</div>

<?php include 'modals.php'; ?>

<script>
    $(document).ready(function(){
    // PROVINCE
        $('#addProvinceBtn').click(function () {
            $('#provinceId').val('');
            $('#provinceName').val('');
            $('#provinceSubmitBtn').text('Save');
            $('#provinceModal').modal('show');
        });

        $('.editProvinceBtn').click(function () {
            $('#provinceId').val($(this).data('id'));
            $('#provinceName').val($(this).data('name'));
            $('#provinceSubmitBtn').text('Update');
            $('#provinceModal').modal('show');
        });

        // DISTRICT
        $('#addDistrictBtn').click(function () {
            $('#districtId').val('');
            $('#districtName').val('');
            $('#districtProvince').val('');
            $('#districtSubmitBtn').text('Save');
            $('#districtModal').modal('show');
        });

        $('.editDistrictBtn').click(function () {
            $('#districtId').val($(this).data('id'));
            $('#districtName').val($(this).data('name'));
            $('#districtProvince').val($(this).data('province'));
            $('#districtSubmitBtn').text('Update');
            $('#districtModal').modal('show');
        });

        // CITY
        $('#addCityBtn').click(function () {
            $('#cityForm')[0].reset();
            $('#cityId').val('');
            $('#citySubmitBtn').text('Save');
            $('#cityModal').modal('show');
        });

        $('.editCityBtn').click(function () {
            let btn = $(this);

            $('#cityId').val(btn.data('id'));
            $('#cityDescription').val(btn.data('description'));
            $('#cityName').val(btn.data('name'));

            let activities = btn.data('activities') || [];
            let highlights = btn.data('highlights') || [];

            $('#cityActivitiesWrapper').html('');
            $('#cityHighlightsWrapper').html('');

            activities.forEach(function (activity) {
                $('#cityActivitiesWrapper').append(
                    '<input type="text" name="cityActivities[]" class="form-control mb-2" value="' + activity + '">'
                );
            });

            highlights.forEach(function (highlight) {
                $('#cityHighlightsWrapper').append(
                    '<input type="text" name="cityHighlights[]" class="form-control mb-2" value="' + highlight + '">'
                );
            });

            $('#cityProvince').val(btn.data('province'));

            $.get('get_districts.php', { province_id: btn.data('province') }, function (data) {
                $('#cityDistrict').html(data);
                $('#cityDistrict').val(btn.data('district'));
            });

            $('#citySubmitBtn').text('Update');
            $('#cityModal').modal('show');
        });

        $('#cityProvince').change(function(){
            var provinceId = $(this).val();
            if(provinceId){
                $.get('get_districts.php', {province_id: provinceId}, function(data){
                    $('#cityDistrict').html(data);
                });
            } else { $('#cityDistrict').html('<option value="">Select District</option>'); }
        });
    });
</script>

<script>
$(document).ready(function () {
    if (window.location.hash) {
        const triggerEl = document.querySelector(
            `a[data-bs-target="${window.location.hash}"]`
        );
        if (triggerEl) {
            new bootstrap.Tab(triggerEl).show();
        }
    }
});
</script>


</body>
</html>
