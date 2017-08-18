<?php
 include './header.php';
 include './navbar.php';
 require('./services/EventService.php');
 
 if(!isset($_GET['id'])){
     header("Location: calendar.php");
     exit;
 }
 $id = $_GET['id'];
 if(!is_numeric($id)){
     header("Location: calendar.php");
     exit;
 }

 $calendar_event = EventService::findOne($id);

 if(!isset($calendar_event)){
     header("Location: calendar.php");
     exit;
 }
?>

<div class="container">
<div class="row">
<br>
<br>
<br>
    <div class="col s12 m6 l12 center">
   <img src="<?=($calendar_event->getPath() == null)?'./img/parallax1.png':$calendar_event->getPath()?>" width="230px" height="230px">
    </div>
    <div class="col s12 m6 l12 center">
            <h4 class="blue-text text-darken-3"><?= $calendar_event->getEvent_Name() ?></h4>
            <h5 class="yellow-text"><?= $calendar_event->getDate() ?></h5>
    </div>
    <div class="col s12 m6 l12">
        <p><?= $calendar_event->getDetails() ?></p>
    </div>
</div>
</div>
  
<?php include 'footer.php'; ?>


