<?php 
session_start();
include 'header.php';
require ('../services/EventService.php');
 
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
<h2 class="center blue-text text-darken-3">Event Manager</h2>
 <form class="form-inline" >
                    <div class="col s12 m4 l8"> 
                        <input type="text" class="form-control right" name="q" placeholder="Search">
                    </div>
                    
                    <div class="col s12 m4 l4"> 
                    <button type="submit" class="waves-effect waves-light btn blue darken-3">Search</button>
                    </div>
</form>

<div class="center-align add-new">
<a href="./eventmanagementform.php" class="waves-effect waves-light btn center-align blue darken-3"><i class="material-icons right">library_add</i>Add New Event</a>
</div>
<br>

<table class="striped highlight responsive-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php foreach($eventList as $event) : ?>  
                        <tr>
                            <td><?= $event->getEvent_Name()?></td>
                            <td><?= $event->getDate()?></td>
                            <td>  
                            <?php $end= (strlen($event->getDetails()) > 80 )? 80 : strlen($event->getDetails());  ?>
                            <?= substr($event->getDetails(), 0, $end).'...'; ?></td>
                            <td>
                                <a href=<?= '../view_event.php?id='.$event->getId()?>>View</a> &nbsp|
                                <a href=<?= './eventmanagementform.php?id='.$event->getId()?>>Edit</a> &nbsp | &nbsp
                                <a href="<?='../actions/event_actions.php?id='.$event->getId().'&delete=yes'?>">Delete</a>
                            </td>
                            
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--Pagination -->
               
                <ul class="pagination center">

                <?php if($page_num != 1): ?>
                <li class="waves-effect blue darken-3"><a href="eventmanagement.php?page_num=<?=$page_num - 1?>"><i class="material-icons yellow">chevron_left</i></a></li>
                <?php endif; ?>
                    
                <?php for( $i =1; $i <= $numberOfPages; $i++):?>
                    
                <li class="blue darken-3 active <?=($page_num == $i)?'active':''?>"><a class="page-link" <?=($page_num == $i)?' ':"href= 'eventmanagement.php?page_num=$i'"?> > <?=$i ?></a></li>
                <?php endfor;?>

                <?php if($page_num != $eventService->getNumberOfPages() &&  $eventService->getNumberOfPages() != 0): ?>

                <li class="waves-effect blue darken-3"><a href="eventmanagement.php?page_num=<?=$page_num + 1?>"><i class="material-icons yellow">chevron_right</i></a></li>
                    <?php endif; ?>
                </ul>



              </div>
            </div>



