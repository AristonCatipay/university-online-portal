<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["editUserData"])) {
  // $ = $_POST[""];
  $user_id = $_POST["user-id"];
  $department = $_POST["department"];
  $user_type_id = $_POST["user-type-id"];
  $first_name = $_POST["first-name"];
  $middle_name = $_POST["middle-name"];
  $last_name = $_POST["last-name"];
  $gender = $_POST["gender"];
  $birthday = $_POST["birthday"];
  $contact_no = $_POST["contact_no"];
  $email = $_POST["email"];
 
  if ($user_id){
  $db->query("UPDATE `users` SET `department_id`='{$department}',`user_type_id`='{$user_type_id}',`first_name`='{$first_name}',`middle_name`='{$middle_name}',`last_name`='{$last_name}',`birthday`='{$birthday}',`gender`='{$gender}',`email`='{$email}',`contact_no`='{$contact_no}' WHERE id = '$user_id';");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success"] = "Data has been updated successfully.";
  }else{
    $_SESSION["failed"] = "Data is already in the database.";
  }
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="index.php" method="POST">
                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col">
                            <label for="fname">First Name</label><br />
                            <div class="input-group">
                                <input type="hidden" name="user-id" id="user-id" class="form-control" />
                                <input type="text" name="first-name" id="first-name" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="mname">Middle Name</label><br />
                            <div class="input-group">
                                <input type="text" name="middle-name" id="middle-name" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="lname">Last Name</label><br />
                            <div class="input-group">
                                <input type="text" name="last-name" id="last-name" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="gender">Gender</label><br />
                            <div class="input-group">
                                <select name="gender" id="user-gender" class="form-control">
                                    <option value="" selected disabled></option>
                                    <option value="male">MALE</option>
                                    <option value="female">FEMALE</option>
                                </select>
                                <span class="input-group-text border"><i class="fas fa-solid fa-mars-and-venus"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="bday">Birthdate</label><br />
                            <div class="input-group">
                                <input type="date" name="birthday" id="birthday" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="contact_no">Contact No</label><br />
                            <div class="input-group">
                                <input type="text" name="contact_no" id="contact-no" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="email">Email</label><br />
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <label for="status">Department</label><br />
                        <div class="input-group">
                            <select name="department" id="department-id" class="form-select">
                                <option value="" selected="true" disabled="disabled"></option>
                                <?php
                  $db->query("SELECT `id`,`department_name` FROM user_department;"); $db->execute(); $status_query = $db->resultSet(); $db->closeStmt(); foreach ($status_query as $row) { ?>
                                <option value="<?= $row->id?>"><?= $row->department_name?></option>
                                <?php
                  };
                  ?>
                            </select>
                            <span class="input-group-text"><i class="fas fa-solid fa-building-user"></i></span>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <label for="status">User Type</label><br />
                        <div class="input-group">
                            <select name="user-type-id" id="user-type-id" class="form-select">
                                <option value="" selected="true" disabled="disabled"></option>
                                <?php
                  $db->query("SELECT `id`,`type_name` FROM user_type;"); 
                  $db->execute(); $status_query = $db->resultSet(); 
                  $db->closeStmt(); 
                  foreach ($status_query as $row) { ?>
                                <option value="<?= $row->id?>"><?= $row->type_name?></option>
                                <?php
                  };
                  ?>
                            </select>
                            <span class="input-group-text"><i class="fas fa-solid fa-user-gear"></i></span>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                </div>
                <!-- modal-body closing -->
                <div class="modal-footer w-100">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit"  value="Submit" name="editUserData" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
