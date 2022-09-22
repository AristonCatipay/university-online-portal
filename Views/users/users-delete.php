<?php 
require_once "../../Controllers/Database.php";

$db = new Database();

  if(isset($_POST["deleteRow"])){
    $db->query("SELECT profile_file_name FROM users WHERE id='{$_POST['id']}';");
    $db->execute();
    $db->closeStmt();
    $profile_file_name = $db->resultSet();
    $profile_file_name = $profile_file_name[0]->profile_file_name;
    $path = "../../Assets/img/profiles/". $profile_file_name;
    if (file_exists($path) == false){
      $_SESSION["failed"] = "Unsuccessful data deletion.";
    }
    else {
      if (!unlink($path)){
        $_SESSION["failed"] = "Unsuccessful data deletion.";
      }
      else {
        $db->query("DELETE FROM users WHERE id='{$_POST['id']}';");
        $db->execute();
        $db->closeStmt();
        $_SESSION["success"] = "Data has been removed successfully.";
      }
    }
  }
?>

<div class="modal fade modal-lg" id="deleteModal" tabindex="3" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this data?
      </div>

      <form action="./index.php" method="POST">
      <input type="hidden" name="id" id="delete-id">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="deleteRow" class="btn btn-danger">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>