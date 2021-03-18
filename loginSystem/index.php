<?php 

declare(strict_types=1);

namespace App;

require_once("Controller.php");
$configuration = require_once("config.php");

$request = [
          'get' => $_GET,
          'post' => $_POST
          

];

Controller::initConfiguration($configuration);
$controller = new Controller($request);
$controller->run();

