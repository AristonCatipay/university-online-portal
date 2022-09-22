<?php

$departments = ['All Department', 'Information Technology', 'Teachers Department'];
$selected_department = "All Department";
if (isset($_GET["selected_department"])) $selected_department = $_GET["selected_department"];
?>
<section class="d-flex gap-2 py-3">
  </form>
  <form id="department-filter-form"  method="GET" class="d-flex gap-2">
    <select  class="form-select w-max" id="selected_department" name="selected_department">
      <?php foreach ($departments as $department) : ?>
        <option <?= $selected_department == $department ? "selected" : ""  ?> value="<?= $department ?>"><?= $department ?></option>
      <?php endforeach ?>
    </select>
  </form>
</section>

<script>
  $(document).ready(function() {
    $("#selected_department").change(function() {
      $("#department-filter-form").submit();
      console.log($("#department-filter-form"));
    });
  });
</script>