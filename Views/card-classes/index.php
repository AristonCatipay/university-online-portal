<?php
// ONLY COPY THIS TEMPLATE! DO NOT EDIT THIS FILE!
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
setTitle("Classroom");
$db = new Database();
$table_name = "My Class";

allow_specific_designation_only(["TEACHER", "DEVELOPER", "STUDENT"]);

// Add your filter functionality here.
// $filter_department = null;
// if (isset($_GET["selected_department"])) {
//   $filter_department = $_GET["selected_department"];
// }
// End of filter functionality here.



if (isset($_POST["submit-class-id"])) {
    $_SESSION['class_id'] = $_POST["id"];
    $_SESSION['section_id'] = $_POST["section-id"];
    $url = "../card-class-post/index.php";
    header('Location: '.$url);
    die();
}
?>

<!-- Add required files here. -->
<?php require_once "../../Templates/sidebar.php"; ?>
<?php //require_once("./ -add.php"); ?>
<?php //require_once("./ -edit.php"); ?>
<?php //require_once("./ -delete.php"); ?>
<!-- End of required files here. -->


<div class="main-content w-100">

<!-- This will show success and failed cards -->
  <?php
  if (isset($_SESSION["success"])) { ?>
    <div class="alert alert-success text-success">
      <?php
      echo $_SESSION["success"];
      unset($_SESSION["success"]);
      ?>
    </div> <?php
          }
            ?>

  <?php
  if (isset($_SESSION["failed"])) { ?>
    <div class="alert alert-danger text-danger">
    <?php
        echo $_SESSION["failed"];
        unset($_SESSION["failed"]);
        ?>
      </div> 
      <?php
        }
        ?>
<!-- End of success and failed cards -->


<!-- This page should only be seen by user type admin -->
    <div>
        <?php //require_once "./template-filters.php"; ?>
    </div>
    <!-- Tabs at the top of the data table. -->
    <!-- Change the class of the i tag using bootstrap icons. -->
    <!-- Add the title which will serve as the title shown when tooltip is icon is hovered -->
    <!-- <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href=""><i class="" data-toggle="tooltip" data-placement="top" title=""></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href=""><i class="" data-toggle="tooltip" data-placement="top" title=""></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=""><i class="" data-toggle="tooltip" data-placement="top" title=""></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=""><i class="" data-toggle="tooltip" data-placement="top" title=""></i></a>
            </li>
        </ul>
    </div> -->
    <!-- End of tabs at the top of the data table. -->
</div>

<h4 class="my-2">Classes</h4>
        <div class="row equal">
        <?php 
             $db->query("SELECT
             `classes`.`id`,
             `classes`.`user_id`,
             `users`.`first_name`,
             `users`.`middle_name`,
             `users`.`last_name`,
             `users`.`profile_file_name`,
             `classes`.`section_id`,
             `section`.`section_name`,
             `classes`.`class_code`,
             `classes`.`class_name`
         FROM
             `classes`,
             `users`,
             `section`
         WHERE
             `classes`.`user_id` = `users`.`id` AND `classes`.`section_id` = `section`.`id`;");
              $db->execute();
              $result = $db->resultSet();
              $db->closeStmt();
              foreach ($result as $row){ 
              ?>
                <div class="col-xl-4 col-lg-6 cursor-pointer" >
                <div class="card card-link overflow-hidden text-white h-100" style="background: white ;border-left: #D4AF37 solid 8px;">
                    <div class="card-statistic-3 p-4 w-100 h-150">
                        <div class="d-flex justify-content-between flex-column h-100">
                            <div>
                                <h5 class="d-flex align-items-center mb-0" _msthash="1214941" _msttexthash="32955" style="color: black;"><?= $row->class_code ?></h5>
                                
                                <p class="fs-a" style="color: black;"><?= $row->class_name?></p>
                                <p class="fs-b" style="color: black;"><?= $row->section_id." | ".$row->section_name?></p>
                                <p class="fs-a" style="color: black;"><?= $row->first_name." ".$row->middle_name." ".$row->last_name ?></p>
                                <form action="index.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $row->id?>">
                                    <input type="hidden" name="section-id" value="<?= $row->section_id?>">
                                    <button type="submit" value="Submit" name="submit-class-id" class="btn btn-primary">Enter</button>
                                </form>
                            </div>

        <div class="logo">
        <img class="img-fluid" src ="<?= "../../Assets/img/profiles/".$row->profile_file_name; ?>"  style="float: right; height: 100px; width: 100px; border-radius: 50%; border: 2px solid #D4AF37; margin-top: 15px;">
        </a>    
    </div>

                        </div>
                    </div>
                </div>
            </div>
<?php
        } ;
             ?>


<script src="../../Assets/js/datatables_functions.js"></script>
</script>
</body>