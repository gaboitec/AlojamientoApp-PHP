<?php
require_once './modules/controllers/UserController.php';
require_once './modules/controllers/AcomodationController.php';

$UserController = new UserController;
//$AcomodationController = new AcomodationController;

if (isset($_GET['session'])) {
    $UserController->login();
}
