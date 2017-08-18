<?php include './header.php'; ?>
<?php include './navbar.php'; ?>

<div class="container">
	<br>
	<iframe id="iframe" src= "./lib/ViewerJS/#../../assets/files/Handbook.pdf" width='100%' height='600px' allowfullscreen webkitallowfullscreen></iframe>
</div>

<?php include './footer.php'; ?>

<script type="text/javascript">
	$('#iframe').ready(function() {
	   setTimeout(function() {
	      $('#iframe').contents().find('#about').remove();
	   }, 100);
	});
</script>

