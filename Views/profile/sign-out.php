<?php
  session_start();
  require_once "../../Controllers/Functions.php";
  unset_logged_in_session();
  redirect('../../index.php');
?>