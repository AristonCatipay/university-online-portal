<?php
session_start();
require_once "./Controllers/Functions.php";
require_once "./Controllers/Database.php";
$db = new Database();

if (isset($_POST["signIn"])) {
    $id = trim($_POST["id"]);

    $db->query("SELECT
    `users`.`id`,
    `users`.`department_id`,
    `user_department`.`department_name`,
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
    `user_department`,
    `user_type`
WHERE
    users.department_id = user_department.id AND users.user_type_id = user_type.id AND users.id = '{$id}';");

    $db->execute();
    $logged_in_user = $db->fetch();
    
    if ($db->rowCount() > 0){
        $_SESSION['logged_in_id'] = trim($_POST["id"]);
        $_SESSION['logged_in_profile_file_name'] = $logged_in_user["profile_file_name"];
        $_SESSION['logged_in_full_name'] = "{$logged_in_user["first_name"]} {$logged_in_user["last_name"]}";
        $_SESSION['logged_in_user_type'] = $logged_in_user["type_name"];
        $_SESSION['logged_in_password'] = $logged_in_user["password"];
        $_SESSION['logged_in_date_activated'] = $logged_in_user["date_activated"];
        $_SESSION['logged_in_user_department'] = $logged_in_user["department"];

        if (!empty($_POST["id"]) && empty($_POST["password"]) && empty($logged_in_user["password"])) {
            redirect("./Views/profile/password-reset.php");
            die();
        }

        if ($db->rowCount() == 0 || !password_verify($_POST["password"], $logged_in_user["password"])) {
            unset_logged_in_session();
            $_SESSION["error"] = "Invalid User Id or Password.";
            $_SESSION["state_id"] = $_POST["id"];
        } 
        else {
            if($logged_in_user["date_activated"] == null){
                redirect("./Views/profile/setup.php");
            }
            else{
                redirect("./Views/dashboard");
            }
        }
    }
    else {
        $_SESSION["error"] = "Invalid user ID or password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> University Online Portal | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="./Assets/img/logo/logo(500x500)withoutbg.png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="././Assets/css/style.css">
</head>

<body class="login-form-bg">
    <div class="login-form rounded shadow-lg p-4">
        <div class="text-center">
            <img src="./Assets/img/logo/logo(500x500).png" alt="" width="220" height="220">
    
            <?php
            if (isset($_SESSION["error"])) { ?>
                <div class="alert alert-danger text-danger">
                    <?php
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                    ?>
                </div> <?php
                    }
                        ?>
        </div>

        <form class="d-flex flex-column pt-2 px-1" method="POST">
            <div class="form-floating mb-3">
                <input name="id" type="text" class="form-control" id="floatingInput" placeholder="id">
                <label for="floatingInput">User ID</label>
            </div>
            <div class="form-floating">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="text-center mt-4">
                <button type="submit" name="signIn" class="btn btn-warning w-100">Sign in</button>
            </div>
        </form>

        <div class="text-center mt-4" style="line-height: 14px;">
            <h6 class="fw-bold fs-f">Developed by: Ariston Catipay</h6>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-warning w-30" onclick="window.location.href = 'index.php';">Home</button>
            </div>
        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>