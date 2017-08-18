<?php 
session_start();
require('./services/UserService.php');
// if(UserService::isLogin()){
//      header("location: ./Dashboard.php");
//     exit;
// }
?>

<?php 
include './header.php'; 
include './navbar.php';
?>



<div class="container">
<div class="row">
<div class="card col s12 l12">
                    <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger  alert-dismissible" role="alert"  id="error-alert">
                          <button type="button" class="close waves-effect waves-light btn yellow" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                          Invalid username or password
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_GET['success'])): ?>
                        <div class="alert alert-success  alert-dismissible" role="alert"  id="error-alert">
                            <button type="button" class="close waves-effect waves-light btn yellow" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                            Your password has been changed.
                        </div>
                    <?php endif; ?>
                    </div>

<div class="col s12 m4 l2"><p></p></div>
<div class="col s12 m4 l8 center login-card">
<div class="card blue darken-3">
            <div class="card-content yellow-text">
              <h4 class="yellow-text">Login</h4>
              <form action="./actions/login.php" method="post">
          <div class="input-field">
          <i class="material-icons prefix">account_circle</i>
          <input id="idnumber" name="idnumber" type="text" class="validate yellow-text" required>
          <label class="white-text" for="idnumber">ID Number</label>
          </div>
          <div class="input-field">
          <i class="material-icons prefix">lock</i>
          <input id="password" name="password" type="password" class="validate yellow-text" required>
          <label class="white-text" for="password">Password</label>
          </div>
                        <button class="button waves-effect waves-light btn yellow" type="submit">Login</button>
               </form>
            </div>
          </div>
        </div>
<div class="col s12 m4 l2"><p></p></div>                 
</div>
</div>
<?php include './footer.php'; ?>