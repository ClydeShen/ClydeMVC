<?php
require_once 'config.php';
require_once 'libs/Bootstrap.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';

// Library
require_once 'libs/Database/Query.php';
require_once 'libs/Database/Database.php';
require_once 'libs/Database/Result.php';
require_once 'libs/Form.php';
require_once 'libs/Session.php';
require_once 'libs/Auth.php';
// Load the Bootstrap!
$bootstrap = new Bootstrap();

// Optional Path Settings
//$bootstrap->setControllerPath();
//$bootstrap->setModelPath();
//$bootstrap->setDefaultFile();
//$bootstrap->setErrorFile();

$bootstrap->init();