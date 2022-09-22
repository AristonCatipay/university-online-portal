<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
setTitle("User Accounts");
$db = new Database();
$table_name = "User Accounts";


$filter_department = null;
if (isset($_GET["selected_department"])) {
  $filter_department = $_GET["selected_department"];
}
?>

<?php require_once "../../Templates/sidebar.php"; ?>
<?php require_once("./users-add.php"); ?>
<?php //require_once("./users-edit.php"); ?>
<?php //require_once("./users-delete.php"); ?>


<div class="main-content w-100">

<!-- This will show success and failed cards -->
  <?php
  if (isset($_SESSION["success"])) { ?>
    <div class="alert alert-success text-success">
      <?php
      echo $_SESSION["success"];
      unset($_SESSION["success"]);
      ?>
    </div> <?php
          }
            ?>

  <?php
  if (isset($_SESSION["failed"])) { ?>
    <div class="alert alert-danger text-danger">
    <?php
        echo $_SESSION["failed"];
        unset($_SESSION["failed"]);
        ?>
      </div> 
      <?php
        }
        ?>
<!-- End of success and failed cards -->


<!-- This page should only be seen by user type admin -->
  <h4 class="py-2"><?= $table_name ?></h4>
    <div>
        <?php require_once "./users-filters.php"; ?>
    </div>
    <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php">Table View</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./users-grid.php">Grid View</a>
            </li>
        </ul>
    </div>
    <div class="p-4 shadow-sm table-container">
        <table id="datatable-main" class="table table-striped" style="width: 100%;"></table>
    </div>
</div>


<?php
$select_user_query = "SELECT
`users`.`id`,
`users`.`designation_id`,
`user_designation`.`designation_name`,
`users`.`user_type_id`,
`user_type`.`type_name`,
`users`.`date_activated`,
`users`.`password`,
`users`.`first_name`,
`users`.`middle_name`,
`users`.`last_name`,
`users`.`profile_file_name`,
`users`.`birthday`,
`users`.`gender`,
`users`.`email`,
`users`.`contact_no`
FROM
`users`,
`user_designation`,
`user_type`
WHERE
users.designation_id = user_designation.id AND users.user_type_id = user_type.id";
if ($filter_department && $filter_department != "All Department") {
    $select_user_query = $select_user_query . " user_designation.designation_name='{$filter_department}'";
}
$db->query($select_user_query);
$db->execute();
$db->closeStmt();
$accounts = [
    "rows" => json_encode($db->resultSet()),
    "columns" => json_encode([
        "id" => "ID",
        "type_name" => "Type",
        "designation_name" => "Designation",
        "first_name" => "First name",
        "middle_name" => "Middle name",
        "last_name" => "Last name",
        "gender" => "Gender",
        "birthday" => "Birthday",
        "contact_no" => "Contact No",
        "email" => "Email",
        "designation_id" => "",
        "user_type_id" => "",
    ]),
];
?>


<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($accounts["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($accounts["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows, columns, mainDataTableId, tableName);

    // Pass the data to the edit page input form
    $(mainDataTableId).on('click', 'td.editor-edit', function(e) {
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#user-id").val(rowObject['id']);
      $("#designation_id").val(rowObject['designation_id']);
      $("#user-type-id").val(rowObject['user_type_id']);
      $("#first-name").val(rowObject['first_name']);
      $("#middle-name").val(rowObject['middle_name']);
      $("#last-name").val(rowObject['last_name']);
      $("#user-gender").val(rowObject['gender']);
      $("#birthday").val(rowObject['birthday']);
      $("#contact-no").val(rowObject['contact_no']);
      $("#email").val(rowObject['email']);
      // $("#").val(rowObject['']); Send the data to the form using ID
    });

    // Delete record
    $(".delete-button").click(function(){
      var id = $(this).closest("tr").get(0).id;
      $("#delete-id").val(id);
    });

    console.log(columns);
    var columnArr = Object.keys(columns);

    // Store Data into the edit button
    $("#datatable-main tbody tr").each(function() {
      var element = $(this);
      console.log(element);
      var rowObject = {};
      var i = 0;
      element.children('td').each(function () {
        var textData = $(this).text().trim();
        rowObject[columnArr[i]] = textData;
        // if(i == [number of columns])
        if(i == 12){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    });

    // Make the data invisible from table
    $("#datatable-main tbody tr td:nth-child(11)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <span class="invisible">${tdData}</span>
        `
        );
      }); 
    
    $("#datatable-main tbody tr td:nth-child(12)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}</span>
      `
      );
    }); 
    // End of making data invisible from table


  }); 
</script>
</body>