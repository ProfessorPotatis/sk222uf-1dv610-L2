<?php
//INCLUDE THE FILES NEEDED...
require_once('model/Database.php');
require_once('model/Session.php');

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

require_once('controller/RouteController.php');
require_once('controller/LoginController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$routeController = new RouteController();

try {
    $routeController->route();
} catch (Exception $e) {
    echo $e;
}