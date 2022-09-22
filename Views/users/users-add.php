<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
require_once "../../Controllers/Date.php";

$db = new Database();
$date = new Date();

if (isset($_POST["add-user"])) {
    $first_name = $_POST["add-first-name"];
    $middle_name = $_POST["add-middle-name"];
    $last_name = $_POST["add-last-name"];
    $gender = $_POST["add-gender"];
    $designation = $_POST["add-designation"];
    $add_user_type = $_POST["add-user-type-id"];

    do {
        $user_id = $date->getYear() . "-" . randomWord();
        $db->query("SELECT id FROM users WHERE id = '{$user_id}'");
        $db->execute();
        $db->closeStmt();
    } while ($db->rowCount() != 0);

    $db->query("INSERT INTO `users`(`id`,`designation_id`, `user_type_id`, `date_activated`,`first_name`, `middle_name`, `last_name`, `birthday`, `gender`, `email`, `contact_no`) VALUES ('{$user_id}','{$designation}','{$add_user_type}',NULL,
  '{$first_name}','{$middle_name}','{$last_name}',NULL,'{$gender}',NULL,NULL);");
    $db->execute();
    $db->closeStmt();
    $_SESSION["success"] = "Data has been added successfully.";
}
?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="index.php" method="POST">
                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col">
                            <label for="add-first-name">First Name</label><br />
                            <div class="input-group">
                                <input type="text" name="add-first-name" class="form-control" required/>
                                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="add-middle-name">Middle Name</label><br />
                            <div class="input-group">
                                <input type="text" name="add-middle-name" class="form-control" required/>
                                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="add-last-name">Last Name</label><br />
                            <div class="input-group">
                                <input type="text" name="add-last-name" class="form-control" required/>
                                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <div class="col">
                            <label for="add-gender">Gender</label><br />
                            <div class="input-group">
                                <select name="add-gender" class="form-control" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="input-group-text border"><i class="fas fa-solid fa-mars-and-venus"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <label for="add-designation">Designation</label><br />
                        <div class="input-group">
                            <select name="add-designation" class="form-select" required>
                                <option value="" selected="true" disabled="disabled"></option>
                                <?php
                                $db->query("SELECT `id`,`designation_name` FROM user_designation;");
                                $db->execute();
                                $status_query = $db->resultSet();
                                $db->closeStmt();
                                foreach ($status_query as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->designation_name?></option>
                                <?php }
                                ?>
                            </select>
                            <span class="input-group-text"><i class="fas fa-solid fa-building-user"></i></span>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->

                    <div class="row mt-2">
                        <label for="add-user-type-id">User Type</label><br />
                        <div class="input-group">
                            <select name="add-user-type-id" class="form-select" required>
                                <option value="" selected="true" disabled="disabled"></option>
                                <?php
                                $db->query("SELECT `id`,`type_name` FROM user_type;");
                                $db->execute();
                                $status_query = $db->resultSet();
                                $db->closeStmt();
                                foreach ($status_query as $row) { ?>
                                <option value="<?= $row->id ?>"><?= $row->type_name ?></option>
                                <?php }
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
                    <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" value="Submit" name="add-user" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>