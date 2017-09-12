<?php
session_start();

//INCLUDE THE FILES NEEDED...
include('DBConfig.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/LoginController.php');
require_once('model/Database.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();

//CREATE DATABASE
$db = new Database($db_host, $db_name, $db_user, $db_password);
//$db->addUser('Admin', 'Password');


$lv->render(false, $v, $dtv);