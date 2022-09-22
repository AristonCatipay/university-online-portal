<?php
require_once "../../Controllers/Database.php";

$db = new Database();

$edit_card = null;
if (isset($_GET["edit-card-id"])) {
  $db->query("SELECT * FROM dashboard_cards WHERE id = {$_GET["edit-card-id"]}");
  $db->execute();
  if (sizeof($db->resultSet()) > 0) $edit_card = $edit_card = $db->resultSet()[0];
  $db->closeStmt();
}

if (isset($_POST["edit-card"])) {
  $db->query("UPDATE dashboard_cards SET page_path = '{$_POST["page_path"]}',title = '{$_POST["title"]}', color = '{$_POST["color"]}', icon_name = '{$_POST["icon_name"]}', result_query = '{$_POST["result_query"]}' WHERE id = {$_POST["id"]};");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-card"] = "Card successfully edited.";
}

$is_editing = $edit_card != null;
?>
<?php if ($is_editing) : ?>
  <section>
    <div class="modal fade" data-bs-backdrop="static" id="editModal" tabindex="5" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Card</h5>
            <button type="button" class="btn-close cancel-edit" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="./index.php" method="POST">
              <input type="hidden" name="id" value="<?= $edit_card->id ?>">
              <div class="mb-3">
                <label for="title" re class="form-label">Title</label>
                <input type="text" required class="form-control" placeholder="Card title" name="title" id="title" value="<?= $edit_card->title ?>" aria-describedby="title">
              </div>
              <div class="mb-3">
                <label for="page_path" class="form-label">Page path</label>
                <input type="text" value="<?= $edit_card->page_path ?>" placeholder="Path where the page will redirect when clicked" class="form-control" name="page_path" id="page_path" aria-describedby="page_path">
                <div id="page_path" class="form-text">Leave blank to make it as data summary (not clickable)</div>
              </div>
              <div class="mb-3">
                <label for="color" class="form-label">Card color</label>
                <input type="color" value="<?= $edit_card->color ?>" required class="form-control" name="color" id="color" aria-describedby="color">
              </div>
              <div class="mb-3">
                <label for="icon_name" class="form-label">Icon name</label>
                <input type="text" value="<?= $edit_card->icon_name ?>" required class="form-control" placeholder="Font Awesome icon name (eg.fa-solid fa-arrow-right-long)" name="icon_name" id="icon_name" aria-describedby="icon_name">
              </div>

              <div class="mb-3">
                <label for="result_query" class="form-label">Result Query</label>
                <textarea rows="4" cols="50" required class="form-control" placeholder="SQL Query to show result (eg. SELECT COUNT(id) AS result FROM users;)" name="result_query" id="result_query" aria-describedby="result_query"><?= $edit_card->result_query ?></textarea>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-edit" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="edit-card" class="btn btn-primary">Edit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </section>

<?php endif ?>

<script>
  var isEditing = '<?= $is_editing ?>';
  var editModal = new bootstrap.Modal(document.getElementById("editModal"), {});
  document.onreadystatechange = function() {
    if (isEditing) editModal.show();
    $(".cancel-edit").click(function(){
      location.href = location.protocol + '//' + location.host + location.pathname;
    });
  };
</script>