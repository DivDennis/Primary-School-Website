<?php
include './header.php';
include './navbar.php';
require ('./services/EventService.php');

$eventService = new EventService();
    $page_num = 1;
    $event = null;

if(isset($_GET['page_num'])){
         if($_GET['page_num'] > 1 && $_GET['page_num'] > $eventService->getCount()){
             $page_num = 1;
         }
         else if($_GET['page_num']>1){
            $page_num = $_GET['page_num'];
         }
    }
    if(isset($_GET["q"])){
       $eventList = $eventService->getByLimit($page_num, 8, $_GET["q"]);
    }else{
       $eventList = $eventService->getByLimit($page_num, 8);
    }
    $numberOfPages = $eventService->getNumberOfPages();
?>

<div class="container">
<h2 class="blue-text text-darken-3 center">Calendar</h2>
<div class="alert alert-info" role="alert"> <h4 class="blue-text"> Upcomming Events </h4> </div>

<?php foreach($eventList as $event) : ?> 
 <div class="row">
    <div class="col s12 m6 l3">
    <img src="<?=($event->getPath() == null)?'./img/parallax1.png':$calendar_event->getPath()?>" width="200px" height="140px">
    </div>
    <div class="col s12 m6 l7">
        <h5 class="blue-text text-darken-3"> <?= $event->getEvent_Name() ?> </h5>
        <?php $end= (strlen($event->getDetails()) > 200 )? 200 : strlen($event->getDetails());  ?>
        <?= substr($event->getDetails(), 0, $end).'...'; ?>
        <br>
        <a href="<?= 'view_event.php?id='.$event->getId() ?>">See More</a>
    </div>

<?php endforeach; ?>

<?php if(count($eventList) < 1): ?>
<h4 class="blue-text text-darken-3 center">No Event found </h4>
<?php else: ?>
<br />
<?php endif; ?>

</div>

<ul class="pagination center">

                <?php if($page_num != 1): ?>
                <li class="waves-effect blue darken-3"><a href="calendar.php?page_num=<?=$page_num - 1?>"><i class="material-icons yellow">chevron_left</i></a></li>
                <?php endif; ?>
                    
                <?php for( $i =1; $i <= $numberOfPages; $i++):?>    
                <li class="blue darken-3 active <?=($page_num == $i)?'active':''?>"><a class="page-link" <?=($page_num == $i)?' ':"href= 'calendar.php?page_num=$i'"?> > <?=$i ?></a></li>
                <?php endfor;?>

                <?php if($page_num != $eventService->getNumberOfPages() &&  $eventService->getNumberOfPages() != 0): ?>

                <li class="waves-effect blue darken-3"><a href="calendar.php?page_num=<?=$page_num + 1?>"><i class="material-icons yellow">chevron_right</i></a></li>
                    <?php endif; ?>
                </ul>

</div>
<?php include './footer.php' ?>
