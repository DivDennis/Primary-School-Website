<?php
 session_start();
 include './header.php';
 $page = 5;
 require_once dirname(__FILE__).'/../services/UserService.php';
 require_once dirname(__FILE__).'/../classes/User.php';
 require_once dirname(__FILE__).'/../common/Security.php';
?> 

<?php
    $userService = new UserService();
      
    if(isset($_POST['submit'])){
        if(strcmp($_POST['confirm_password'], $_POST['new_password'])!=0){
            header("location: ./change-password.php?error=3");
            exit;
        }
        
        $user = new User();
        $user->setIdnumber($userService->getUserSession()["idnumber"]);

        $hash = Security::getHash($_POST["old_password"], $userService->getUserSession()["salt"]);
        if(strcmp("".$userService->getUserSession()["password"]."", "".$hash."") == 0){
            $salt = Security::getSalt();
            $hash = Security::getHash($_POST["new_password"], $salt);
            $user->setPassword($hash);
            $user->setSalt($salt);
            echo"yyy";
            if($userService->update($user)){
                $userService->unsetUserSession();
                header("location: ../login.php?success=1");
                exit;
            }
        }else{
            header("location: ./change-password.php?error=1");
            exit;
        }

    }
?>

<div class="container">
<div class="row">
<div class="card col s12 l12">
<?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger  alert-dismissible" role="alert"  id="error-alert">
                        <button type="button" class="close waves-effect waves-light btn yellow" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                        <?php if($_GET['error'] == 1): ?>
                           Your old password is incorrect
                        <?php endif; ?>
                        <?php if($_GET['error'] == 3): ?>
                          New passwords don't match
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                    </div>

<div class="col s12 m4 l2"><p></p></div>
<div class="col s12 m4 l8 center login-card">
<div class="card blue darken-3">
            <div class="card-content yellow-text">
              <h4 class="yellow-text">Change Password</h4>
              <form action="./change-password.php" method="post">
          <div class="input-field">
          <i class="material-icons prefix">vpn_key</i>
          <input id="old_password" name="old_password" type="password" class="validate yellow-text" required>
          <label class="white-text" for="old_password">Old Password</label>
          </div>
          <div class="input-field">
          <i class="material-icons prefix">lock</i>
          <input id="new_password" name="new_password" type="password" class="validate yellow-text" required>
          <label class="white-text" for="new_password">New Password</label>
          </div>
          <div class="input-field">
          <i class="material-icons prefix">lock</i>
          <input id="cofirm_password" name="confirm_password" type="password" class="validate yellow-text" required>
          <label class="white-text" for="new_password">New Password</label>
          </div>
                        <button class="button waves-effect waves-light btn yellow" type="submit">Save New Password</button>
               </form>
            </div>
          </div>
        </div>

<script src='../lib/ckeditor/ckeditor.js'></script>