<?php

$is_with_date_filter = true;

if (isset($_GET["date_filter"])) $is_with_date_filter = boolval($_GET["date_filter"]);

$months = getMonths();
$year_now = date("Y");
$month_now = date('F');
$day_now = date("d");
$selected_year = $year_now;
if (isset($_GET["year"])) $selected_year = $_GET["year"];

$selected_month = $month_now;
if (isset($_GET["month"])) $selected_month = $_GET["month"];

$selected_day = $day_now;
if (isset($_GET["day"])) $selected_day = $_GET["day"];

$days_selected_month = cal_days_in_month(CAL_GREGORIAN,array_search($selected_month, $months) + 1,2022);
?>
<section class="d-flex gap-2 py-3">
  
<form action="./index.php" class="d-flex  gap-2" method="GET">
  <select id="filter-toggle"  class="form-select w-max " name="date_filter">
    <option <?= !$is_with_date_filter ? "selected" : ""  ?> value="0">All Records</option>
    <option  <?= $is_with_date_filter ? "selected" : ""  ?> value="1">Costum</option>
  </select>
</form>
<form id="advance_filter" action="./index.php" method="GET" class="d-flex gap-2 <?= $is_with_date_filter ? "visible" : "invisible"  ?>">
  <select class="form-select w-max onchange-form-submit" name="month">
    <?php foreach ($months as $month) : ?>
      <option  <?= $month == $selected_month ? "selected" : ""  ?> value="<?= $month ?>"><?= $month ?></option>
    <?php endforeach ?>
  </select>
  <select class="form-select w-max onchange-form-submit" name="day" >
    <?php for ($day = 1; $day <= $days_selected_month; $day++) : ?>
      <option  <?= $day == $selected_day ? "selected" : ""  ?> value="<?= $day ?>"><?= $day ?></option>
    <?php endfor ?>
  </select>
  <select class="form-select w-max onchange-form-submit" name="year" >
    <?php for ($year = $year_now; $year >= $year_now - 5; $year--) : ?>
      <option  <?= $year == $selected_year ? "selected" : ""  ?> value="<?= $year ?>"><?= $year ?></option>
    <?php endfor ?>
  </select>
</form>
</section>

<script>
$( ".onchange-form-submit" ).change(function() {
  $(this).parent().submit();
});

$( "#filter-toggle" ).change(function() {
  $value = $(this).val();
  if($value != 0){
    $("#advance_filter").submit();
  }else{
    $(this).parent().submit();
  }
});

</script>
