<?php
 session_start();
 require ('../services/EventService.php'); 
 include 'header.php';
?> 

<?php
    $eventService = new EventService();
    $page_num = 1;
    $event = null;
    if(isset($_GET["id"])){
        $event = EventService::findOne($_GET["id"]);
        if($event->getId() < 1){
            header("location: ./eventmanagementform.php");
            exit;
        }
    }
    if(isset($_GET['page_num'])){
         if($_GET['page_num'] > 1 && $_GET['page_num'] > $eventService->getCount()){
             $page_num = 1;
         }
         else if($_GET['page_num']>1){
            $page_num = $_GET['page_num'];
         }
    }
    if(isset($_GET["q"])){
       $eventList = $eventService->getByLimit($page_num, 10, $_GET["q"]);
    }else{
       $eventList = $eventService->getByLimit($page_num, 10);
    }
    $numberOfPages = $eventService->getNumberOfPages();

?>
<div class="container">
<div class="row">

<div class="col s12 m4 l4"><p>
    <?php include './sidenav.php'; ?>
</p></div>

<div class="col s12 m4 l8"><p>
<h3 class="center blue-text text-darken-3">Add New Event</h3>

<?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger  alert-dismissible" role="alert"  id="error-alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <?php if($_GET['error'] == 2): ?>
                            Event Already Exists
                        <?php endif; ?>
                        <?php if($_GET['error'] == 5): ?>
                           Images must be JPEG or PNG
                        <?php endif; ?>
                        <?php if($_GET['error'] == 1): ?>
                           You must supply a event name
                        <?php endif; ?>
                        <?php if($_GET['error'] == 3): ?>
                           You must supply a date
                        <?php endif; ?>
                        <?php if($_GET['error'] == 4): ?>
                           You must supply details about the event
                        <?php endif; ?>
                        <?php if($_GET['error'] == 9): ?>
                           Server error. contact admin.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>


<form action="<?= (isset($event))?'../actions/event_actions.php?id='.$event->getId():'../actions/event_actions.php'?>" method="post" enctype="multipart/form-data">
<div class="form-group center-align"> 
<h5 class="center yellow-text">Preview</h5>
<img id="img-output" src="<?=((isset($event))?($event->getPath()!=null)?$event->getPath():'../img/placehold.png':'../img/placehold.png')?>"  width="200px" height="200px">
</div>
<div class="form-group">
<input type="file" name="file" id="exampleInputFile" onchange="previewImage(event)">
<p class="help-block"></p>
</div>
<div class="form-group">
<label for="first_name">Event Name</label>
<input type="text" value="<?=(isset($event))?$event->getEvent_Name():''?>" class="form-control" name="event_name" minlength="1" maxlength="90" required>
</div>
<div class="form-group">
<label for="first_name">Date</label>
<input type="text" value="<?=(isset($event))?$event->getDate():''?>" class="form-control" name="date" placeholder="eg. July 12, 1880 - June 28, 1946" required>
</div>
<div class="form-group">
<label for="details">Details</label>
<textarea id="details" type="text" name="details" class="ckeditor" required><?=(isset($event))?$event->getDetails():''?></textarea>
</div>
<br>
<br>
<button type="submit" class="waves-effect waves-light btn center-align blue darken-3"><?= (isset($event))?'Save Changes':'Insert'?></button>

</form>
</div>
</div>


<script src='../lib/ckeditor/ckeditor.js'></script>
<script>
 
 var previewImage = function(event) {
    var output = document.getElementById('img-output');
    output.src = URL.createObjectURL(event.target.files[0]);
 };
</script>
