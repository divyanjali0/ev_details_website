<!-- Province Modal -->
<div class="modal fade" id="provinceModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="provinceForm">
        <div class="modal-header">
          <h5 class="modal-title">Province</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="provinceId" id="provinceId">
          <input type="text" name="provinceName" class="form-control" id="provinceName" placeholder="Province Name" required>
        </div>
        <div class="modal-footer">
          <button type="submit" name="save" class="btn btn-success">Save</button>
          <button type="submit" name="update" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- District Modal -->
<div class="modal fade" id="districtModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="districtForm">
        <div class="modal-header">
          <h5 class="modal-title">District</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="districtId" id="districtId">
          <input type="text" name="districtName" class="form-control mb-2" id="districtName" placeholder="District Name" required>
          <select name="districtProvince" id="districtProvince" class="form-select" required>
              <option value="">Select Province</option>
              <?php
              $pRes = $conn->query("SELECT * FROM provinces");
              while($p = $pRes->fetch_assoc()){
                  echo "<option value='{$p['id']}'>{$p['name']}</option>";
              }
              ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" name="save" class="btn btn-success">Save</button>
          <button type="submit" name="update" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- City Modal -->
<div class="modal fade" id="cityModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" id="cityForm">
        <div class="modal-header">
          <h5 class="modal-title">City</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="cityId" id="cityId">

          <div class="mb-3">
              <label>Province</label>
              <select name="cityProvince" id="cityProvince" class="form-select" required>
                  <option value="">Select Province</option>
                  <?php
                  $pRes = $conn->query("SELECT * FROM provinces");
                  while($p = $pRes->fetch_assoc()){
                      echo "<option value='{$p['id']}'>{$p['name']}</option>";
                  }
                  ?>
              </select>
          </div>

          <div class="mb-3">
              <label>District</label>
              <select name="cityDistrict" id="cityDistrict" class="form-select" required>
                  <option value="">Select District</option>
              </select>
          </div>

          <div class="mb-3">
              <input type="text" name="cityName" id="cityName" class="form-control" placeholder="City Name" required>
          </div>

          <div class="mb-3">
              <textarea name="cityDescription" id="cityDescription" class="form-control" placeholder="Description"></textarea>
          </div>

          <div class="mb-3">
              <textarea name="cityActivities" id="cityActivities" class="form-control" placeholder="Key Activities"></textarea>
          </div>

          <div class="mb-3">
              <textarea name="cityHighlights" id="cityHighlights" class="form-control" placeholder="City Highlights"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="save" class="btn btn-success">Save</button>
          <button type="submit" name="update" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
