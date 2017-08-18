<?php
session_start();
require('../services/UserService.php');
require('../common/Security.php');

$user = new User();
$user->setIdnumber($_POST["idnumber"]);
$user->setPassword($_POST["password"]);

$user = UserService::login($user);

if($user->getIdnumber() != null){
    $hash = Security::getHash($_POST["password"], $user->getSalt());
    if(strcmp($user->getPassword(), $hash) == 0){
        UserService::setUserSession($user);
        header("location: ../AdminManagement/Dashboard.php");
        exit;
    }
}

header("location: ../login.php?error=1");
exit;
