<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
$table_name = "Setup Profile";
allow_all_authenticated_only();
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
allow_all_authenticated_only();
$logged_in_id = trim($_SESSION["logged_in_id"]);

$select_logged_in_query = "SELECT * FROM users WHERE id = '".$logged_in_id."'";
$db->query($select_logged_in_query);
$db->execute();
$logged_in_user = $db->fetch();
$db->closeStmt();

if(!$logged_in_user)redirect("./sign-out.php");

if(!empty($logged_in_user["date_activated"])){
	redirect('../dashboard');
}

if (isset($_POST["set_up_account"])) {

	$last_name = $_POST["last_name"];
	$middle_name = $_POST["middle_name"];
	$first_name = $_POST["first_name"];
	$gender = $_POST["gender"];
	$birthday = $_POST["birthday"];
	$contact_no = $_POST["contact_no"];
	$profile_file_name = $_FILES['profile_file_name'];
	$profile_file_name_extract_name = extract_name($profile_file_name);
	$profile_file_name_extract_ext = extract_ext($profile_file_name_extract_name);
	$profile_file_name_extract_tmp_name = extract_tmp_name($profile_file_name);

	$imagePath = "../../Assets/img/profiles/";
	$unique_file_name = $logged_in_id.'.'.$profile_file_name_extract_ext;
	if(is_uploaded_file($profile_file_name_extract_tmp_name)) {
		if(move_uploaded_file($profile_file_name_extract_tmp_name, $imagePath . $unique_file_name)) {
			$db->query("UPDATE users SET profile_file_name = '{$unique_file_name}', first_name = '{$first_name}', middle_name= '{$middle_name}', last_name = '{$last_name}' , gender='{$gender}', birthday='{$birthday}', contact_no='{$contact_no}', date_activated=now()  WHERE id='{$logged_in_id}';");
			$db->execute();
			$db->closeStmt();
			$_SESSION['logged_in_id'] = $logged_in_id;
			$_SESSION['logged_in_profile_file_name'] = $unique_file_name;
			$_SESSION['logged_in_full_name'] = "{$first_name} {$last_name}";
			redirect('../dashboard');
		}
	}
}

?>


<link rel="stylesheet" type="" href="../../Assets/css/profile.css">

<section class="backdrop-light-gray py-3 px-2">
	<div class="container">
		<div class="d-flex justify-content-between">
			<h4 class="py-2 d-block"><?= $table_name ?></h4>
		</div>
		<div class="w-100">
			<div class="row d-flex justify-content-center">
				<div class="card-profile p-3 py-4 shadow-sm">
					<div class="row">
						<div class="text-center col-12 col-lg-3 d-flex flex-column gap-2">
							<span class="fw-bold text-secondary">Profile Image</span>
							<img id="profile_file_name_preview" src="../../Assets/img/profiles/<?= $logged_in_user['profile_file_name'] ?>" width="120" height="120" class="rounded-circle mx-auto shadow-sm">
							<div class="d-flex flex-column gap-1">
								<div class="mb-3 px-3">
									<input form="setup-user-form" accept="image/png, image/gif, image/jpeg" required class="form-control form-control-sm" name="profile_file_name" id="profile_file_name" type="file">
								</div>
							</div>
						</div>
						<div class="text-center col-12 col-lg-9">
							<form id="setup-user-form" class="row" method="POST" enctype="multipart/form-data">
								<div class="mb-3 col-lg-4">
									<label for="first_name" class="form-label fs-e text-start text-secondary w-100">First name</label>
									<input required type="text" name="first_name" class="form-control" value="<?= $logged_in_user['first_name'] ?>" id="first_name" aria-describedby="first_name" />
								</div>
								<div class="mb-3 col-lg-4">
									<label for="middle_name" class="form-label fs-e text-start text-secondary w-100">Middle name</label>
									<input required type="text" name="middle_name" class="form-control" value="<?= $logged_in_user['middle_name'] ?>" id="middle_name" aria-describedby="middle_name" />
								</div>
								<div class="mb-3 col-lg-4">
									<label for="last_name" class="form-label fs-e text-start text-secondary w-100">Last name</label>
									<input required type="text" name="last_name" class="form-control" value="<?= $logged_in_user['last_name'] ?>" id="last_name" aria-describedby="last_name" />
								</div>
								<div class="mb-3 col-lg-4">
									<label for="contact_no" class="form-label fs-e text-start text-secondary w-100">Contact Number</label>
									<input required type="text" name="contact_no" class="form-control" value="<?= $logged_in_user['contact_no'] ?>" id="contact_no" aria-describedby="contact_no" />
								</div>
								<div class="mb-3 col-lg-4">
									<label for="gender" class="form-label fs-e text-start text-secondary w-100">Gender</label>
									<select class="form-select" id="gender" name="gender">
										<option <?= $logged_in_user['gender'] == "Male" ? "selected" : "" ?> value="male">Male</option>
										<option <?= $logged_in_user['gender'] == "Female" ? "selected" : "" ?> value="female">Female</option>
									</select>
								</div>
								<div class="mb-3 col-lg-4">
									<label for="birthday" class="form-label fs-e text-start text-secondary w-100">Birthday</label>
									<input required type="date" name="birthday" class="form-control" value="<?= $logged_in_user['birthday'] ?>" id="birthday" aria-describedby="birthday" />
								</div>
								<div class="my-auto d-flex justify-content-end">
									<button name="set_up_account" class="btn btn-primary w-max fs-6 d-flex gap-2">
										<span>Save Changes</span>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<div>
</div>


<?php


$db->query("SELECT * from users;");
$db->execute();
$accounts = array(
	"rows" => json_encode($db->resultSet()),
	"columns" => json_encode(array(
		"id" => "ID",
		"first_name" => "First name",
		"middle_name" => "Middle name",
		"last_name" => "Last name",
		"gender" => "Gender",
		"birthday" => "Birthday",
	))
);
$db->closeStmt();
//print_r($accounts["rows"]);
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
		// Edit record
		$(mainDataTableId).on('click', 'td.editor-edit', function(e) {

		});

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