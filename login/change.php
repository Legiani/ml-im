<?php
  /*
	* Autoloader
	*/
	spl_autoload_register(function ($class_name) {
    include '../class/'.$class_name . '.php';
  });

	// Load base class
  $web = new base();

  if (isset( $_POST['mail'], $_POST['key'], $_POST['password'], $_POST['passwordCheck']) and ($_POST['password'] == $_POST['passwordCheck'])){
    echo $web->changePassword($_POST['mail'], $_POST['key'], $_POST['password']);
  }
?>

<!doctype html>
<html lang="en" class="h-100">
  <?php
    include("../themes/head.php");
  ?>
  <body class="text-center h-100 overflow-hidden">
    <?php
      include("../themes/nav.php");
    ?>    
    <div class="container h-100">
      <section class="row h-100">
        <div class="col-dm-6 my-auto mx-auto">
          <form class="form-signin" method="POST">
            <input type="hidden" name="key" value="<?php echo $_GET["key"];?>">
            <input type="hidden" name="mail" value="<?php echo $_GET["forget"];?>">
            <img class="mb-4" src="../img/logo.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal"><?php echo $web->getConf("changeHeading");?></h1>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input class="form-control" placeholder="<?php echo $web->getConf("regPassword");?>" type="password" name="password" required>
              </div> 
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input class="form-control" placeholder="<?php echo $web->getConf("passwordCheck");?>" type="password" name="passwordCheck" required>
              </div> 
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit"> <?php echo $web->getConf("changeButton");?></button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017-2019</p>
          </form>
        </div>
      </section>  
    </div>  
  </body>
</html>
