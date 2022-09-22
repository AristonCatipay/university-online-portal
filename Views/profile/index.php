<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
$table_name = "My Profile";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
$db->query("SELECT
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
users.designation_id = user_designation.id AND users.user_type_id = user_type.id AND users.id = '{$_SESSION["logged_in_id"]}';");
$db->execute();
$user = $db->fetch();
$db->closeStmt();
allow_all_fully_authenticated();
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
<link rel="stylesheet" type="" href="../../Assets/css/profile.css">

<div class="main-content w-100">
  <div class="d-flex justify-content-between">

    <h4 class="py-2 d-block"><?= $table_name ?></h4>
    <div class="my-auto">
      <a href="./edit.php" class="btn btn-primary w-max mx-auto fs-e d-flex gap-2">
        <span>Edit Profile</span>
        <i class="fa-solid fa-pencil my-auto"></i>
      </a>
    </div>
  </div>
  <div class="w-100">
    <div class="row d-flex justify-content-center">
      <div class="card-profile p-3 py-4 shadow-sm">
        <div class="row">
          <div class="text-center col-12 col-lg-3 d-flex flex-column gap-2">
            <span class="fw-bold text-secondary">Profile Image</span>
            <img src="../../Assets/img/profiles/<?= $user["profile_file_name"] ?>" width="120"  height="120" class="rounded-circle mx-auto">
            <div class="d-flex flex-column gap-1">
              <span class="badge bg-secondary w-max mx-auto text-capitalize"><?= $user["type_name"] ?></span>
              <span class="badge bg-success w-max mx-auto text-capitalize"><?= $user["designation_name"] ?></span>
            </div>
          </div>
          <div class="text-center col-12 col-lg-9">
            <form class="row">
              <div class="mb-3 col-lg-4">
                <label for="first_name" class="form-label fs-e text-start text-secondary w-100">First name</label>
                <input type="text" disabled class="form-control" value="<?= $user["first_name"] ?>" id="first_name" aria-describedby="first_name" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="middle_name" class="form-label fs-e text-start text-secondary w-100">Middle name</label>
                <input type="text" disabled class="form-control" value="<?= $user["middle_name"] ?>" id="middle_name" aria-describedby="middle_name" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="last_name" class="form-label fs-e text-start text-secondary w-100">Last name</label>
                <input type="text" disabled class="form-control" value="<?= $user["last_name"] ?>" id="last_name" aria-describedby="last_name" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="contact_no" class="form-label fs-e text-start text-secondary w-100">Contact Number</label>
                <input type="text" disabled class="form-control" value="<?= $user["contact_no"] ?>" id="contact_no" aria-describedby="contact_no" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="gender" class="form-label fs-e text-start text-secondary w-100">Gender</label>
                <select class="form-select" disabled id="gender" name="gender">
                  <option <?= $user["gender"] == "male" ? "selected" : "" ?> value="male">Male</option>
                  <option  <?= $user["gender"] == "female" ? "selected" : "" ?> value="female">Female</option>
                </select>
              </div>
              <div class="mb-3 col-lg-4">
                <label for="birthday" class="form-label fs-e text-start text-secondary w-100">Birthday</label>
                <input type="date" disabled class="form-control" value="<?= $user["birthday"] ?>" id="birthday" aria-describedby="birthday" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="email" class="form-label fs-e text-start text-secondary w-100">Email</label>
                <input type="text" disabled class="form-control" value="<?= $user["email"] ?>" id="email" aria-describedby="email" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div>
</div>

<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    
  });
</script>
</body>