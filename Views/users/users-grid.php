<?php
session_start();
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
require_once "../../Templates/header_view.php";
setTitle("User Accounts");
$db = new Database();
require_once("./users-add.php");

$table_name = "User Accounts";
$filter_designation = null;
if (isset($_GET["selected_designation"])) {
  $filter_designation = $_GET["selected_designation"];
}

$active_accounts_query = "SELECT
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
users.designation_id = user_designation.id AND users.user_type_id = user_type.id AND users.date_activated IS NOT NULL"; 
if ($filter_designation && $filter_designation != "All Designation") {
  $active_accounts_query = $active_accounts_query ." AND user_designation.designation_name='{$filter_designation}'";
}
$db->query($active_accounts_query);
$db->execute();
$active_accounts = $db->resultSet();
$db->closeStmt();

$unctivated_accounts_query = "SELECT
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
users.designation_id = user_designation.id AND users.user_type_id = user_type.id AND users.date_activated IS NULL";
if ($filter_designation && $filter_designation != "All Designation") {
  $unctivated_accounts_query = $unctivated_accounts_query . " AND user_designation.designation_name='{$filter_designation}'";
}
$db->query($unctivated_accounts_query);
$db->execute();
$unactivated_accounts = $db->resultSet();
$db->closeStmt();
$unactivated_accounts_copy_text = "";
?>

<?php require_once "../../Templates/sidebar.php"; ?>
<div class="main-content w-100">
  <h4 class="py-2"><?= $table_name ?></h4>
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

  <div>
    <?php require_once "./users-filters.php"; ?>
  </div>
  <div>
    <ul class="nav nav-tabs flex-row justify-content-start">
      <li class="nav-item">
        <a class="nav-link " href="./index.php">Table View</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link active" aria-current="page" href="./users-grid.php">Grid View</a>
      </li>
    </ul>
  </div>
  <div class="p-4 shadow-sm table-container container ">
    <section class="row equal mb-4">
      <div class="py-1 col-12 mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
          Add User Accounts
        </button>
      </div>
      <div class="bg-secondary text-white py-1 col-12 mb-3 rounded shadow-sm">
        <span>Unactivated Accounts</span>
      </div>
      
      <?php if ($unactivated_accounts) : ?>
        <?php if (sizeof($unactivated_accounts) > 0) : ?>
          <div class="col-12 d-flex justify-content-end mb-3">
            <button id="unactivated-copy-text" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#unactivated-copy-text-modal">
              <i class="fa-solid fa-clipboard mx-2"></i>
              <span>Copy List as Text</span>
            </button>
          </div>
        <?php endif ?>
        <?php foreach ($unactivated_accounts as $account) :
          $acc_full_name = "{$account->last_name}, {$account->first_name}";
          $unactivated_accounts_copy_text = "{$unactivated_accounts_copy_text} {$account->id} - {$acc_full_name} | {$account->type_name} | {$account->department_name} \n";
        ?>
          <div class="p-2 col-12 col-md-4 col-lg-3 col-xl-2 ">
            <div class="shadow-sm p-3 col-12 h-100">
              <img src="../../Assets/img/profiles/<?= $account->profile_file_name ?>" height="90" width="90" class="mb-2 d-block mx-auto" alt="...">
              <div class="card-body d-flex flex-column gap-1">
                <h6 class="card-title text-center"><?= $acc_full_name ?></h6>
                <h6 class="card-title text-center"><?= "{$account->id}" ?></h6>
                <span class="badge bg-success w-max mx-auto text-capitalize"><?= "{$account->type_name}"?></span>
                <span class="badge bg-secondary w-max mx-auto text-capitalize"><?= "{$account->designation_name}"?></span>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      <?php else : ?>
        <h3 class="text-center text-secondary my-3">No Record</h3>
      <?php endif ?>
    </section>

    <section class="row equal mb-4">
      <div class="bg-success text-white py-1 col-12 mb-3 rounded shadow-sm">
        <span>Activated Accounts</span>
      </div>
      
      <?php if ($active_accounts) : ?>
        <?php foreach ($active_accounts as $account) :
          $acc_full_name = "{$account->last_name}, {$account->first_name}";
        ?>
          <div class="p-2 col-12 col-md-4 col-lg-3 col-xl-2 ">
            <div class="shadow-sm p-3 col-12 h-100">
              <img src="../../Assets/img/profiles/<?= $account->profile_file_name ?>" height="90" width="90" style="border-radius: 50%;" class="mb-2 d-block mx-auto" alt="...">
              <div class="card-body d-flex flex-column gap-1">
                <h6 class="card-title text-center"><?= $acc_full_name ?></h6>
                <h6 class="card-title text-center"><?= "{$account->id}" ?></h6>
                <span class="badge bg-success w-max mx-auto text-capitalize"><?= "{$account->type_name}"?></span>
                <span class="badge bg-secondary w-max mx-auto text-capitalize"><?= "{$account->designation_name}"?></span>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      <?php else : ?>
        <h3 class="text-center text-secondary my-3">No Record</h3>
      <?php endif ?>
    </section>


  </div>
</div>

<!-- Copied Modal -->
<div class="modal fade modal-auto-clear" id="unactivated-copy-text-modal" tabindex="-1" aria-labelledby="unactivated-copy-text-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Copied</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        List of Activated Account Copied to Clipboard
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var unactivated_accounts_copy_text = `<?= $unactivated_accounts_copy_text ?>`;
    $("#unactivated-copy-text").click(function() {
      navigator.clipboard.writeText(unactivated_accounts_copy_text);
    });
    $('.modal-auto-clear').on('shown.bs.modal', function() {
      $(this).delay(1000).fadeOut(200, function() {
        $(this).modal('hide');
      });
    })
  });
</script>
</body>