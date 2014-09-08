<?php

require_once("View/HTMLView.php");
require_once("Controller/LoginController.php");

$controller = new LoginController();

$htmlView = new HTMLView("Hello, world");
$htmlView->echoHTML();
