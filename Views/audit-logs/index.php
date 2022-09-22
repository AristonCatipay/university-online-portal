<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
$table_name = "Audit logs";
setTitle($table_name);
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Date.php";
$db = new Database();
$date = new Date();
allow_all_authenticated_only();
?>


<?php require_once "../../Templates/sidebar.php"; ?>
<?php if($_SESSION["logged_in_user_type"] == "viewer"):?>
<style>
  #datatable-main .delete-button {
    display:none;    
  }
  #datatable-main .edit-button {
    display:none;    
  }
</style>
<?php endif?>
<div class="main-content w-100">
  <h4 class="py-2"><?= $table_name ?></h4>
  <div class="p-4 shadow-sm table-container">
    <?php require_once "./filters.php"; ?>
    <table id="datatable-main" class="table table-striped w-100"></table>
  </div>
</div>

<div>
</div>


<?php

$log_filter = "";

if ($is_with_date_filter) $log_filter = " WHERE audit_logs.timestamp LIKE CONCAT('{$selected_month}', '%', '{$selected_day}', '%', '{$selected_year}', '%')";

$db->query("SELECT * FROM audit_logs
RIGHT JOIN users
ON users.id = audit_logs.user_id
{$log_filter}
");
$db->execute();
$logs = array(
  "rows" => json_encode($db->resultSet()),
  "columns" => json_encode(array(
    "id" => "#",
    "timestamp" => "timestamp",
    "log" => "Log",
  ))
);
$db->closeStmt();
?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($logs["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($logs["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows, columns, mainDataTableId, tableName, {
      isWithEditor: false,
      isWithAddButton: false,
      paging: false
    });
    // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function(e) {

    });

    if (rows.length > 0) {
      var rowCounter = 1;
      $("#datatable-main tbody tr td:nth-child(1)").each(function() {
        $(this).text(rowCounter);
        rowCounter++;
      });
    }

  });
</script>
</body>