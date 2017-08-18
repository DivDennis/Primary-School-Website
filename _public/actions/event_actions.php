<?php 
require_once dirname(__FILE__).'/../services/EventService.php';
require_once  dirname(__FILE__).'/../classes/Events.php';

$event = new Event();




    if(isset($_GET["id"])){
        $event->setId($_GET["id"]);
    }
    
    if(isset($_GET["delete"]) && isset($_GET["id"])){
        if(!eventService::delete($event->getId())){
        }
        header("location: ../AdminManagement/eventmanagement.php");
        exit;
    }
    
    if(!strcmp($_FILES['file']['tmp_name'], "") ==0){
        if (!in_array( $_FILES['file']['type'], array ('image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png') )){
            header("location: ../AdminManagement/eventmanagementform.php?id=".$_POST['album']."&error=5");
            exit;
        }
    }

    if(strcmp($_POST['event_name'], "") == 0){
        header("location: ../AdminManagement/eventmanagementform.php?error=1");
        exit;
    }

    if(strcmp($_POST['date'], "") == 0){
        header("location: ../AdminManagement/eventmanagementform.php?error=3");
        exit;
    }

    if(strcmp($_POST['details'], "") == 0){
        header("location: ../AdminManagement/eventmanagementform.php?error=4");
        exit;
    }


    $event->setEvent_Name($_POST['event_name']);
    $event->setDate($_POST['date']);
    $event->setDetails($_POST['details']);
    if( $event->getId() == 0){
        $exist = eventService::exist($event);

        if($exist){
            header("location: ../AdminManagement/eventmanagementform.php?error=2");
            exit;
        }

        if(!EventService::insert($event, $_FILES['file'])){
            header("location: ../AdminManagement/eventmanagementform.php?error=9");
            exit;
        }
    }else{
        if(!EventService::update($event, $_FILES['file'])){
            header("location: ../AdminManagement/eventmanagementform.php?error=9");
            exit;
        }
    }
     header("location: ../AdminManagement/eventmanagement.php");
        exit;