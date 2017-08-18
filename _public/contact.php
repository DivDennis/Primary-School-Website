<?php
include './header.php';
include './navbar.php';
?>


<div class="container">
<h2 class="blue-text text-darken-3 center-align">Contact Us</h2>
  <div class="row">
    <form class="col s12">
      <div class="row">
        <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
          <input id="first_name" type="text" class="validate blue-text">
          <label for="first_name">First Name</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Last Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
        <i class="material-icons prefix">email</i>
          <input id="email" type="email" class="validate">
          <label for="email" data-error="wrong" data-success="right">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
        <i class="material-icons prefix">message</i>
          <input id="message" type="text" class="validate">
          <label for="password">Message</label>
        </div>
      </div>
    </form>
  </div>

<div class="center-align">
  <button class="btn waves-effect waves-light blue darken-3 yellow-text" type="submit" name="action">Submit
    <i class="material-icons right">send</i>
  </button>
  </div>
        
</div>



<?php include './footer.php' ?>