<?php
require_once "../../Controllers/Database.php";

$db = new Database();

if (isset($_POST["addCard"])) {
  $page_path = $_POST["page_path"];
  $color = $_POST["color"];
  $title = $_POST["title"];
  $icon_name = $_POST["icon_name"];
  $result_query = $_POST["result_query"];
  $db->query("INSERT INTO dashboard_cards (page_path, color, title, icon_name, result_query)
    VALUES ( '{$page_path}' , '{$color}', '{$title}', '{$icon_name}', '{$result_query}' );");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-card"] = "Card successfully added.";
}

?>
<section>
<div class="modal fade" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Card</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="./index.php" method="POST">
          <div class="mb-3">
            <label for="title" re class="form-label">Title</label>
            <input type="text" required class="form-control" placeholder="Card title" name="title" id="title" aria-describedby="title">
          </div>
          <div class="mb-3">
            <label for="page_path" class="form-label">Page path</label>
            <input type="text" placeholder="Path where the page will redirect when clicked" class="form-control" name="page_path" id="page_path" aria-describedby="page_path">
            <div id="page_path" class="form-text">Leave blank to make it as data summary (not clickable)</div>
          </div>
          <div class="mb-3">
            <label for="color" class="form-label">Card color</label>
            <input type="color" required class="form-control" name="color" id="color" aria-describedby="color">
          </div>
          <div class="mb-3">
            <label for="icon_name" class="form-label">Icon name</label>
            <input type="text" required class="form-control" placeholder="Font Awesome icon name (eg.fa-solid fa-arrow-right-long)" name="icon_name" id="icon_name" aria-describedby="icon_name">
          </div>

          <div class="mb-3">
            <label for="result_query" class="form-label">Result Query</label>
            <textarea rows="4" cols="50" required class="form-control" placeholder="SQL Query to show result (eg. SELECT COUNT(id) AS result FROM users;)" name="result_query" id="result_query" aria-describedby="result_query"></textarea>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="addCard" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
