<?php

require_once("View/HTMLView.php");
require_once("Controller/LoginController.php");

$controller = new LoginController();

$htmlBody = $controller->control();

$htmlView = new HTMLView();
$htmlView->echoHTML($htmlBody);
