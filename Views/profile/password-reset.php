<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
require_once "../../Controllers/Database.php";
$db = new Database();

allow_all_authenticated_only();
$logged_in_id = $_SESSION["logged_in_id"];
$db->query("SELECT * FROM users WHERE id='{$logged_in_id}';");
$db->execute();
$logged_in_user = $db->fetch();
$db->closeStmt();

if(!empty($logged_in_user["password"])){
  redirect('../dashboard');
}


if (isset($_POST["sign_in"])) {
  //https://stackoverflow.com/questions/30279321/how-to-use-phps-password-hash-to-hash-and-verify-passwords
  $password = $_POST["password"];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $db->query("UPDATE users SET password='{$hashed_password}' WHERE id='{$logged_in_id}';");
  $db->execute();
  $db->closeStmt();
  redirect('./setup.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Online Portal | Reset Password</title>
  <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style-with-prefix.css">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="././Assets/css/style.css">

</head>

<body class="">
  <div class="login-form rounded shadow-lg p-4">
    <div class="text-center">
      <img src="../../Assets/img/logo/logo(500x500).png"  height="220">
      <div class="p-1 pb-0">
        <h4 class="title">You are logged in. Set your Password</h4>
      </div>
    </div>
    <!-- form-login -->
    <form class="d-flex flex-column pt-2 px-1" method="post">
      <div class="mt-2">
        <input name="password" required onChange="onChangePassword()" minlength="8" id="password" type="password" class="form-control" placeholder="Password">
      </div>
      <div class="mt-2">
        <input name="confirm_password" required onChange="onChangePassword()" id="confirm_password" type="password" class="form-control" placeholder="Confirm Password">
      </div>
      <div class="text-center mt-4">
        <button type="submit" name="sign_in" class="btn btn-warning w-100">Save Password</button>
      </div>
    </form>
  </div>
  <script>
    function onChangePassword() {
      const password = document.getElementById("password");
      const confirm =document.getElementById("confirm_password");
      if (confirm.value === password.value) {
        confirm.setCustomValidity('');
      } else {
        confirm.setCustomValidity('Passwords do not match');
      }
    }
  </script>
</body>

</html>