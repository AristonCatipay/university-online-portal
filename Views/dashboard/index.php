<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
setTitle("Dashboard");
$db = new Database();
allow_all_fully_authenticated();
$logged_in_user_type = $_SESSION["logged_in_user_type"];
$logged_in_is_web_admin = $logged_in_user_type == "ADMIN";
?> 

<?php require_once "./add.php"; ?>
<?php require_once "./edit.php"; ?>

<?php
$db->query("SELECT * FROM dashboard_cards  
WHERE page_path IS NOT NULL AND page_path != '';");
$db->execute();
$clickable_cards = $db->resultSet();
$db->closeStmt();

$db->query("SELECT * FROM dashboard_cards  
WHERE page_path IS NULL OR page_path = '';");
$db->execute();
$not_clickable_cards = $db->resultSet();
$db->closeStmt();

?>
<?php require_once "../../Templates/sidebar.php"; ?>
<?php if($_SESSION["logged_in_user_type"] == "viewer"):?>
<style>
  #datatable-main .delete-button {
    display:none;    
  }
  #datatable-main .edit-button {
    display:none;    
  }
</style>
<?php endif?>

<main class="py-5 overflow-hidden">

    <?php
    if (isset($_SESSION["success-card"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-card"];
            unset($_SESSION["success-card"]);
            ?>
        </div> <?php
            }
                ?>

    <h3 class="my-2">Dashboard</h3>
        <div class="row equal">
            <?php if($logged_in_is_web_admin): ?>
            <div class="col-xl-3 col-lg-6 cursor-pointer" data-bs-toggle="modal" data-bs-target="#addModal">
                <div class="card card-link overflow-hidden text-white h-100" style="background: linear-gradient(to right, #111111,#14c96c ) !important;">
                    <div class="card-statistic-3 p-4 h-100">
                        <div class="card-icon card-icon-large">
                            <i class="fa-solid fa-file-circle-plus fs" style="font-size: 80px;"></i>
                        </div>
                        <div class="d-flex justify-content-between flex-column h-100  ">
                            <div>
                                <h3 class="d-flex align-items-center mb-0">
                                    Add New Card
                                </h3>

                            </div>
                            <div class="row align-items-end justify-content-end h-100 mb-2 d-flex  mt-3">
                                <div class="px-1  w-max">
                                    <i class="fa-solid fa-plus ml-auto d-block fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif?>

            <?php foreach ($clickable_cards as $card) : ?>
                <?php
                //query of card
                $db->query($card->result_query);
                $db->execute();
                $card_query = $db->resultSet();
                $result = $card_query[0]->result;
                $db->closeStmt();
                ?>
                <div class="col-xl-3 col-lg-6 position-relative">
                    <?php if($logged_in_is_web_admin): ?>
                        <form method="GET">
                            <input type="hidden" name="edit-card-id" value="<?= $card->id ?>">
                            <button type="submit" class="btn btn-success card-edit">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </form>
                    <?php endif ?>
                    <a href="../<?= $card->page_path ?>" class="w-100 h-100">
                        <div class="card card-link overflow-hidden text-white h-100" style="border-left: <?= $card->color ?> solid 8px;">
                            <div class="card-statistic-3 p-4 d-flex justify-content-between flex-column h-100">
                                <div class="card-icon card-icon-large">
                                    <i class="fas <?= $card->icon_name ?>" style="color: <?= $card->color ?>"></i>
                                </div>
                                <div class="mb-4 card-title-container">
                                    <h5 class="card-title mb-0"> <?= $card->title ?> </h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex mt-auto">
                                    <div class="col-12 col-md-8">
                                        <h1 class="d-flex align-items-center mb-0">
                                            <?= $result ?>
                                        </h1>
                                    </div>
                                    <div class="col-12 col-md-4 d-flex flex-column align-items-end">
                                        <div class="px-1 text-white" style="z-index: 2">
                                            <i class="fa-solid fa-arrow-right-long ml-auto d-block fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>

        <!-- Data summary -->
        <div class="row mt-5 equal">
            <h4 class="col-12 text-secondary mt-2 mb-3">Data Summary</h4>
            <?php foreach ($not_clickable_cards as $card) : ?>
                <?php
                //query of card
                $db->query($card->result_query);
                $db->execute();
                $card_query = $db->resultSet();
                $result = $card_query[0]->result;
                $db->closeStmt();
                ?>
                <div class="col-xl-3 col-lg-6 position-relative">
                    <?php if($logged_in_is_web_admin): ?>
                    <form method="GET">
                        <input type="hidden" name="edit-card-id" value="<?= $card->id ?>">
                        <button type="submit" class="btn btn-success card-edit">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </form>
                    <?php endif ?>
                    <div class="card overflow-hidden text-white  h-100" style="border-left: <?= $card->color ?> solid 8px;">
                        <div class="card-statistic-3 p-4 d-flex justify-content-between flex-column h-100">
                            <div class="card-icon card-icon-large"><i class="fas <?= $card->icon_name ?>" style="color: <?= $card->color ?>"></i></div>
                            <div class="mb-4 card-title-container">
                                <h5 class="card-title mb-0"> <?= $card->title ?> </h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h1 class="d-flex align-items-center mb-0">
                                        <?= $result ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <!-- Charts -->
        <!-- <div class="row mt-5">
            <h4 class="col-12 text-secondary my-2">Data Visualization</h4>

            <div class="col-12 col-sm-6 p-3">
                <div class="shadow-sm p-2">
                    <span class="w-100 d-block text-center my-2 fs-5">Distribution of Active Members by Category</span>
                    <canvas id="activeMembersCategoryChart" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="col-12 col-sm-6  p-3">
                <div class="shadow-sm p-2">
                    <span class="w-100 d-block text-center my-2 fs-5">Distribution of Active Members by Region</span>
                    <canvas id="activeMembersRegionChart" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="col-12 col-sm-6  p-3">
                <div class="shadow-sm p-2">
                    <span class="w-100 d-block text-center my-2 fs-5">Distribution of Membership Status</span>
                    <canvas id="membershipStatusChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div> -->
    </div>
</main>
<!-- <script src="../../Assets/js/dashboard_chart.js"></script>
<script> -->
</script>
</body>