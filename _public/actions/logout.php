<?php
session_start();
require_once  dirname(__FILE__).'/../services/UserService.php';

UserService::unsetUserSession();

 header("location: ../index.php");
 exit;