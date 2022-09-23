<?php 
// ONLY COPY THIS TEMPLATE! DO NOT EDIT THIS FILE!
require_once "../../Controllers/Database.php";

$db = new Database();

  if(isset($_POST["deleteRow"])){
    $db->query("DELETE FROM `classes` WHERE id='{$_POST['id']}';");
    $db->execute();
    $db->closeStmt();
    $result = $db->resultSet();
    
    // $_SESSION["failed"] = "Unsuccessful data deletion.";
    $_SESSION["success"] = "Data has been removed successfully.";
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
      <input type="text" name="id" id="delete-id">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="deleteRow" class="btn btn-danger">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>