<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("location: ../user/login.php");
    exit();
}

include("../db/dbh.inc.php");
include("../config.php");
include("../userincludes/userfunctions.inc.php");

require_once('fpdf_include.php');


?>