<?php

session_start();

include 'config.php';
require_once '../db/dbh.inc.php';
require_once 'userfunctions.inc.php';

session_unset();
session_destroy();
header("location: ../user/login.php");
exit();
