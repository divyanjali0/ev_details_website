<?php
include 'db.php';

// Handle form submissions
if(isset($_POST['save']) || isset($_POST['update'])) {

    // Province
    if(isset($_POST['provinceName'])){
        $name = $_POST['provinceName'];
        $id = $_POST['provinceId'];
        if(isset($_POST['save'])){
            $stmt = $conn->prepare("INSERT INTO provinces (name) VALUES (?)");
            $stmt->bind_param("s", $name);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("UPDATE provinces SET name=? WHERE id=?");
            $stmt->bind_param("si", $name, $id);
            $stmt->execute();
        }
        header("Location: index.php");
        exit;
    }

    // District
    if(isset($_POST['districtName'])){
        $name = $_POST['districtName'];
        $province_id = $_POST['districtProvince'];
        $id = $_POST['districtId'];
        if(isset($_POST['save'])){
            $stmt = $conn->prepare("INSERT INTO districts (name, province_id) VALUES (?, ?)");
            $stmt->bind_param("si", $name, $province_id);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("UPDATE districts SET name=?, province_id=? WHERE id=?");
            $stmt->bind_param("sii", $name, $province_id, $id);
            $stmt->execute();
        }
        header("Location: index.php");
        exit;
    }

    // City
    if(isset($_POST['cityName'])){
        $name = $_POST['cityName'];
        $province_id = $_POST['cityProvince'];
        $district_id = $_POST['cityDistrict'];
        $description = $_POST['cityDescription'];
        $activities = $_POST['cityActivities'];
        $highlights = $_POST['cityHighlights'];
        $id = $_POST['cityId'];

        if(isset($_POST['save'])){
            $stmt = $conn->prepare("INSERT INTO cities (name, province_id, district_id, description, key_activities, highlights) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siisss", $name, $province_id, $district_id, $description, $activities, $highlights);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("UPDATE cities SET name=?, province_id=?, district_id=?, description=?, key_activities=?, highlights=? WHERE id=?");
            $stmt->bind_param("siisssi", $name, $province_id, $district_id, $description, $activities, $highlights, $id);
            $stmt->execute();
        }
        header("Location: index.php");
        exit;
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sri Lanka Admin</title>
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
        <li class="nav-item"><a class="nav-link text-white" href="#" data-bs-toggle="tab" data-bs-target="#provinces">Provinces</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" data-bs-toggle="tab" data-bs-target="#districts">Districts</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#" data-bs-toggle="tab" data-bs-target="#cities">Cities</a></li>
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
                                <a href='delete_province.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
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
                                <a href='delete_district.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>
                          </tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Cities -->
        <div class="tab-pane fade" id="cities">
            <h3>Cities</h3>
            <button class="btn btn-success mb-3" id="addCityBtn">➕ Add City</button>
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
                            <div class='accordion-body'>";
                    $cities = $conn->query("SELECT c.*, d.name AS district_name FROM cities c LEFT JOIN districts d ON c.district_id=d.id WHERE c.province_id={$province['id']}");
                    if($cities->num_rows>0){
                        while($city=$cities->fetch_assoc()){
                            echo "<div class='card mb-2'>
                                    <div class='card-body'>
                                        <h5>{$city['name']}</h5>
                                        <span class='badge bg-secondary'>District: {$city['district_name']}</span>
                                        <p>{$city['description']}</p>
                                        <p><strong>Activities:</strong> {$city['key_activities']}</p>
                                        <p><strong>Highlights:</strong> {$city['highlights']}</p>
                                        <button class='btn btn-sm btn-warning editCityBtn'
                                            data-id='{$city['id']}'
                                            data-name='{$city['name']}'
                                            data-province='{$city['province_id']}'
                                            data-district='{$city['district_id']}'
                                            data-description='".htmlspecialchars($city['description'], ENT_QUOTES)."'
                                            data-activities='".htmlspecialchars($city['key_activities'], ENT_QUOTES)."'
                                            data-highlights='".htmlspecialchars($city['highlights'], ENT_QUOTES)."'>Edit</button>
                                        <a href='delete_city.php?id={$city['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </div></div>";
                        }
                    } else { echo "<p>No cities yet.</p>"; }
                    echo "</div></div></div>";
                }
                ?>
            </div>
        </div>

    </div>
</div>

<!-- Modals for Province, District, City -->
<?php include 'modals.php'; ?>

<script>
$(document).ready(function(){

    // Province modal
    $('#addProvinceBtn').click(function(){
        $('#provinceId').val('');
        $('#provinceName').val('');
        $('#provinceModal').modal('show');
    });
    $('.editProvinceBtn').click(function(){
        $('#provinceId').val($(this).data('id'));
        $('#provinceName').val($(this).data('name'));
        $('#provinceModal').modal('show');
    });

    // District modal
    $('#addDistrictBtn').click(function(){
        $('#districtId').val('');
        $('#districtName').val('');
        $('#districtProvince').val('');
        $('#districtModal').modal('show');
    });
    $('.editDistrictBtn').click(function(){
        $('#districtId').val($(this).data('id'));
        $('#districtName').val($(this).data('name'));
        $('#districtProvince').val($(this).data('province'));
        $('#districtModal').modal('show');
    });

    // City modal
    $('#addCityBtn').click(function(){
        $('#cityForm')[0].reset();
        $('#cityId').val('');
        $('#cityModal').modal('show');
    });
    $('.editCityBtn').click(function(){
        var btn = $(this);
        $('#cityId').val(btn.data('id'));
        $('#cityName').val(btn.data('name'));
        $('#cityDescription').val(btn.data('description'));
        $('#cityActivities').val(btn.data('activities'));
        $('#cityHighlights').val(btn.data('highlights'));

        // Load districts via AJAX
        $.get('get_districts.php', {province_id: btn.data('province')}, function(data){
            $('#cityDistrict').html(data);
            $('#cityDistrict').val(btn.data('district'));
        });

        $('#cityProvince').val(btn.data('province'));
        $('#cityModal').modal('show');
    });

    // Update city districts if province changes
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

</body>
</html>
