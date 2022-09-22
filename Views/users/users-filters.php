<?php

$designation = ['All Designation', 'STUDENT', 'TEACHER', 'DEVELOPER'];
$selected_designation = "All Designation";
if (isset($_GET["selected_designation"])) $selected_designation = $_GET["selected_designation"];
?>
<section class="d-flex gap-2 py-3">
  </form>
  <form id="designation-filter-form"  method="GET" class="d-flex gap-2">
    <select  class="form-select w-max" id="selected_designation" name="selected_designation">
      <?php foreach ($designation as $designation) : ?>
        <option <?= $selected_designation == $designation ? "selected" : ""  ?> value="<?= $designation ?>"><?= $designation ?></option>
      <?php endforeach ?>
    </select>
  </form>
</section>

<script>
  $(document).ready(function() {
    $("#selected_designation").change(function() {
      $("#designation-filter-form").submit();
      console.log($("#designation-filter-form"));
    });
  });
</script>