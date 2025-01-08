<?php
require_once './modules/controllers/UserController.php';
//require_once './modules/controllers/AcomodationController.php';

$UserController = new UserController;
//$AcomodationController = new AcomodationController;

$view = isset($_GET['view']) ? $_GET['view'] : '';

if ($view == '')
    include './modules/views/home.php';
else if ($view = "login")
    include './modules/views/auth/login.php';
else if ($view = "register")
    include './modules/views/auth/register.php';
