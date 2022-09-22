<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
allow_all_authenticated_only();
$table_name = "Edit Profile";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
$logged_in_id  = $_SESSION["logged_in_id"];


if (isset($_POST["edit_profile"])) {

	$last_name = $_POST["last_name"];
	$middle_name = $_POST["middle_name"];
	$first_name = $_POST["first_name"];
	$gender = $_POST["gender"];
	$birthday = $_POST["birthday"];
	$contact_no = $_POST["contact_no"];
  $email = $_POST["email"];
	
  if(isset($_FILES['profile_file_name'])){
    $profile_file_name = $_FILES['profile_file_name'];
    $profile_file_name_extract_name = extract_name($profile_file_name);
    $profile_file_name_extract_ext = extract_ext($profile_file_name_extract_name);
    $profile_file_name_extract_tmp_name = extract_tmp_name($profile_file_name);
    $imagePath = "../../Assets/img/profiles/";
    $unique_file_name = $logged_in_id.'='.$_SERVER['REQUEST_TIME'].'.'.$profile_file_name_extract_ext;
    if(is_uploaded_file($profile_file_name_extract_tmp_name)) {
      if(move_uploaded_file($profile_file_name_extract_tmp_name, $imagePath . $unique_file_name)) {
        $db->query("UPDATE users SET profile_file_name = '{$unique_file_name}' WHERE id='{$logged_in_id}';");
        $db->execute();
        $db->closeStmt();
        $_SESSION['logged_in_profile_file_name'] = $unique_file_name;
      }
    }
  }

  $db->query("UPDATE users SET first_name = '{$first_name}', middle_name= '{$middle_name}', last_name = '{$last_name}' , gender='{$gender}', birthday='{$birthday}', contact_no='{$contact_no}' ,email ='{$email}' WHERE id='{$logged_in_id}';");
  $db->execute();
  $db->closeStmt();
 
  $_SESSION['logged_in_full_name'] = "{$first_name} {$last_name}";
  $_SESSION["success-card"] = "User successfully added.";
}

$db->query("SELECT * from users WHERE id='{$logged_in_id}';");
$db->execute();
$user = $db->fetch();
$db->closeStmt();

?>


<?php require_once "../../Templates/sidebar.php"; ?>
<link rel="stylesheet" type="" href="../../Assets/css/profile.css">

<div class="main-content w-100">
  <div class="d-flex justify-content-between">

    <h4 class="py-2 d-block"><?= $table_name ?></h4>

  </div>
  <div class="w-100">
    <div class="row d-flex justify-content-center">
      <div class="card-profile p-3 py-4 shadow-sm">
        <div class="row">
          <div class="text-center col-12 col-lg-3 d-flex flex-column gap-2">
            <span class="fw-bold text-secondary">Profile Image</span>
            <img id="profile_file_name_preview" src="../../Assets/img/profiles/<?= $user["profile_file_name"] ?>" width="120" height="120" class="rounded-circle mx-auto">
            <input form="edit-profile-form" accept="image/png, image/gif, image/jpeg"  class="form-control form-control-sm" name="profile_file_name" id="profile_file_name"  type="file" >
          </div>
          <div class="text-center col-12 col-lg-9">
            <form method="POST" class="row" id="edit-profile-form" enctype="multipart/form-data">
              <div class="mb-3 col-lg-4">
                <label for="first_name" class="form-label fs-e text-start text-secondary w-100">First name</label>
                <input type="text" name="first_name"  class="form-control" value="<?= $user["first_name"] ?>" id="first_name" aria-describedby="first_name" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="middle_name" class="form-label fs-e text-start text-secondary w-100">Middle name</label>
                <input type="text" name="middle_name"  class="form-control" value="<?= $user["middle_name"] ?>" id="middle_name" aria-describedby="middle_name" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="last_name" class="form-label fs-e text-start text-secondary w-100">Last name</label>
                <input type="text" name="last_name"  class="form-control" value="<?= $user["last_name"] ?>" id="last_name" aria-describedby="last_name" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="contact_no" class="form-label fs-e text-start text-secondary w-100">Contact Number</label>
                <input type="text" name="contact_no"  class="form-control" value="<?= $user["contact_no"] ?>" id="contact_no" aria-describedby="contact_no" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="gender" class="form-label fs-e text-start text-secondary w-100">Gender</label>
                <select  class="form-select"  id="gender" name="gender">
                  <option <?= $user["gender"] == "male" ? "selected" : "" ?> value="male">Male</option>
                  <option  <?= $user["gender"] == "female" ? "selected" : "" ?> value="female">Female</option>
                </select>
              </div>
              <div class="mb-3 col-lg-4">
                <label for="birthday" class="form-label fs-e text-start text-secondary w-100">Birthday</label>
                <input type="date" name="birthday"  class="form-control" value="<?= $user["birthday"] ?>" id="birthday" aria-describedby="birthday" />
              </div>
              <div class="mb-3 col-lg-4">
                <label for="email" class="form-label fs-e text-start text-secondary w-100">Email</label>
                <input type="text" name="email" class="form-control" value="<?= $user["email"] ?>" id="email" aria-describedby="email" />
              </div>
              <div class="mb-3 col-lg-12 d-flex justify-content-end">
                <button name="edit_profile" class="btn btn-primary " type="submit">Save Changes</button>
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


<?php
//print_r($accounts["rows"]);
?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    $("#profile_file_name").change(function() {
			previewImage(this);
		});
    function previewImage(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#profile_file_name_preview').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			} else {
				$('#profile_file_name_preview').attr('src', '');
			}
		}
  });
</script>
</body>