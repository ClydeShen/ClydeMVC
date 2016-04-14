<?php
require_once 'config.php';
require_once 'libs/Starter.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';

// Library
require_once 'libs/Database/Query.php';
require_once 'libs/Database/Database.php';
require_once 'libs/Database/Result.php';
require_once 'libs/Session.php';
require_once 'libs/Auth.php';
// Load the Starter!
$starter = new Starter();

// Optional Path Settings
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();

$starter->init();