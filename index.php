<?php
require_once './modules/controllers/UserController.php';
//require_once './modules/controllers/AcomodationController.php';

$UserController = new UserController;
//$AcomodationController = new AcomodationController;

$view = isset($_GET['view']) ? $_GET['view'] : '';


switch($view){
    case '':
        include './modules/views/home.php';
        break;
    
    case 'login':
        include './modules/views/auth/login.php';
        break;

    case 'register':
        include './modules/views/auth/register.php';
        break;
    
    case 'createAcomodation':
        include './modules/views/acomodations/CreateAcomodation.php';
        break;
}

//Si les parece podriamos usar el switch para poder agregar despues mas links de las otras vistas
// if ($view == '')
//     include './modules/views/home.php';
// else if ($view == "login")
//     include './modules/views/auth/login.php';
// else if ($view == "register")
//     include './modules/views/auth/register.php';
