<head>
    <link rel="stylesheet" href="../../Assets/css/sidebar.css">
</head>

<div class="body-pd" id="body-pd">
    <header class="header header-pd shadow-sm d-relative" id="header">
        <div class="d-flex gap-2 align-items-center hover-shadow-sm p-2 cursor-pointer ms-auto profile-header">
            <div class="header_img">
                <?php 
                    if(isset($_SESSION['logged_in_profile_file_name']))$logged_in_profile_file_name = $_SESSION['logged_in_profile_file_name'];
                    if(isset($_SESSION['logged_in_full_name']))$logged_in_full_name = $_SESSION['logged_in_full_name'];
                    if(isset($_SESSION['logged_in_user_type']))$logged_in_user_type = $_SESSION['logged_in_user_type'];
                ?>
                <img src="../../Assets/img/profiles/<?= $logged_in_profile_file_name ?>" alt="">
            </div>
            <h6 class="fs-f text-secondary fw-bold my-auto">
                <?= $logged_in_user_type . ' | ' . $logged_in_full_name ?></h6>
            <i class="fa-solid fa-caret-down"></i>
        </div>
        <div class="bg-white rounded shadow-sm p-3 profile-modal  flex-column gap-3 ">
            <a href="../profile" class="d-flex  gap-2 text-secondary  p-1 cursor-pointer">
                <i class="fa-solid fa-user fs-5"></i>
                <h6 class="my-auto">My Profile</h6>
            </a>
            <a href="../profile/sign-out.php" class="d-flex  gap-2 text-secondary  p-1 cursor-pointer">
                <i class="fa-solid fa-arrow-right-from-bracket fs-5"></i>
                <h6 class="my-auto">Sign Out</h6>
            </a>
        </div>
    </header>
    <div class="l-navbar showSideBar" id="nav-bar">
        <nav class="nav">
            <div class="sidebar">
                <a href="#" class="nav_logo"> <img src="../../Assets/img/logo/logo(500x500)withoutbg.png" alt="Database logo"> <span class="nav_logo-name">DATABASE</span> </a>
                <div class="nav_list">
                    <?php
                    $request_uri  = explode("/", $_SERVER['REQUEST_URI']);
                    $current_file_path = $request_uri[sizeof($request_uri) - 2];
                    if(isset($_SESSION["logged_in_user_type"])){
                        $nav_links_icons = array(
                            // "" => array("path" => "", "icon" => ""),
                            "dashboard" => array("path" => "dashboard", "icon" => "fa-solid fa-table-columns"),
                            "profile" => array("path" => "profile", "icon" => "fa-solid fa-user"),
                            "users" => array("path" => "users", "icon" => "fa-solid fa-users"),
                            "classes" => array("path" => "classes", "icon" => "fa-solid fa-users-rectangle"),
                            "card classes" => array("path" => "card-classes", "icon" => "fa-solid fa-chalkboard-user"),
                            "announcements" => array("path" => "class-announcements", "icon" => "fa-solid fa-bullhorn"), 
                        );
                        // if($_SESSION["logged_in_user_type"] == "viewer"){
                        //     $nav_links_icons = array("dashboard" => array("path" => "dashboard", "icon" => "fa-solid fa-table-columns"),
                        //     "profile" => array("path" => "profile", "icon" => "fa-solid fa-user"),
                        //     "business" => array("path" => "business", "icon" => "fa-solid fa-building"),
                        //     "expo details" => array("path" => "expo-details", "icon" => "fa-solid fa-e"),
                        //     "media partners" => array("path" => "media-partners", "icon" => "fa-solid fa-photo-video"),
                        //     "PTE template links" => array("path" => "pte-link-template", "icon" => "fa-solid fa-book"),
                        //     "point person" => array("path" => "point-person", "icon" => "fa-solid fa-address-book"),
                        // );
                        // }   
                        
                    }
                    ?>

                    <input type="text" class="form-control" list="datalist-links" id="filter-list-input" name="datalist-links" onkeyup="filterList()" placeholder="Search...">
                    <datalist id="datalist-links">
                        <?php
                        foreach ($nav_links_icons as $linkName => $linkInfo) {
                        ?>
                            <option><?= $linkName ?> </option>
                        <?php
                        }
                        ?>
                    </datalist>
                    </input>
                    <div id="filter-list">
                        <?php
                        foreach ($nav_links_icons as $linkName => $linkInfo) {
                        ?>
                            <p>
                                <a href="<?= "../" . $linkInfo["path"] ?>" id="list-items" class=" nav_link  <?= $current_file_path ==  $linkInfo["path"] ? "active" : ""  ?>">
                                    <i class='bx <?= $linkInfo["icon"] ?>  nav_icon'></i>
                                    <span class="nav_name text-capitalize"><?= $linkName ?></span>
                                </a>
                            </p>
                        <?php
                        }
                        ?>
                    </div>
                    <?php

                    ?>

                </div>
            </div>
            <div id="header-toggle" class="nav_link header_toggle">
                <div class="text-white w-max">
                    <i id="toggle-close-icon" class="fa-solid fa-angles-left"></i>
                    <i id="toggle-open-icon" class="fa-solid fa-align-justify"></i>
                </div>
                <span class="nav_name text-capitalize text-break">Toggle Sidebar</span>
            </div>

        </nav>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        document.addEventListener("DOMContentLoaded", function(event) {
            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId)
                // Validate that all variables exist
                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener('click', () => {
                        // show navbar
                        nav.classList.toggle('showSideBar')
                        // change icon
                        toggle.classList.toggle('bx-x')
                        // add padding to body
                        bodypd.classList.toggle('body-pd')
                        // add padding to header
                        headerpd.classList.toggle('header-pd')
                        toggleSideIcon(navId);

                    })
                }
            }

            showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')
            toggleSideIcon('nav-bar');

            function toggleSideIcon(navId) {
                var nav = document.getElementById(navId);
                var isSidebarExpanded = true;
                for (let i = 0; i < nav.classList.length; i++) {
                    const navClass = nav.classList[i];
                    if (navClass == 'showSideBar') {
                        isSidebarExpanded = false;
                        break;
                    }
                }

                if (isSidebarExpanded) {
                    $("#toggle-close-icon").hide();
                    $("#toggle-open-icon").show();
                    $(".main-content").addClass("expanded");
                    $(".table-container").addClass("expanded");
                } else {
                    $("#toggle-close-icon").show();
                    $("#toggle-open-icon").hide();
                    $(".table-container").removeClass("expanded");
                    $(".main-content").removeClass("expanded");
                }
            }

            // Your code to run since DOM is loaded and ready
        });

        function filterList() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("filter-list-input");
            filter = input.value.toUpperCase();
            ul = document.getElementById("filter-list");
            li = ul.getElementsByTagName("p");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>