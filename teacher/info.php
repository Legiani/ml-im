<?php
/*
 * Autoloader
 */
spl_autoload_register(function ($class_name) {
    include '../class/' . $class_name . '.php';
});

// Load base class
$web = new base();

if (isset( $_POST['login'], $_POST['password'])){
    
    if($web->login($_POST['login'], $_POST['password'])){
        header("Location: /teacher");
    }else{
        echo "špatné jmeno nebo heslo";
    }
    
}
if (isset( $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['passwordCheck']) and ($_POST['password'] == $_POST['passwordCheck'])){
    if ($_POST['privaci'] == "on"){
      echo $web->registr($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password']);
    }
}

?>

<!doctype html>
<html lang="en" class="h-100">
  <?php
include "../themes/head.php";
?>
<body class="text-center h-100">
    <?php
      include("../themes/nav.php");
    ?>    
    <div class="container-fluid" id="mainScreen">
        <section class="row h-100" id="background">
            <div class="col-sm-12 my-auto">
                <div class="">
                    <div class="row mb-4 mt-4">
                        <div class="col-9 mx-auto">
                            <h1><?php echo $web->getConf("teacherHeading");?></h1>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-9 mx-auto">
                            <p class="h4"><?php echo $web->getConf("teacherSubtitle");?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">

            <!-- Three columns of text below the carousel -->
            <div class="row m-5">
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="100" height="100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 100x100"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em">100x100</text></svg>
                    <h2>Anna</h2>
                    <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="100" height="100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 100x100"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em">100x100</text></svg>
                    <h2>Heading</h2>
                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="100" height="100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 100x100"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em">100x100</text></svg>
                    <h2>Heading</h2>
                    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->

            <hr>

            <div class="row m-5">
                <div class="col-md-7 my-auto">
                    <h2 class="featurette-heading">Jak to funguje <span class="text-muted">Jednoduše :-)</span></h2>
                    <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
                <div class="col-md-5">
                    <i class="fas fa-question fa-10x"></i>
                </div>
            </div>

            <hr>

            <div class="row m-5">
                <div class="col-md-7 order-md-2 my-auto">
                    <h2 class="featurette-heading">Cena <span class="text-muted">Levně :-)</span></h2>
                    <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <i class="fas fa-comment-dollar fa-10x"></i>

                </div>
            </div>

            <hr>

            <div class="row m-5">
                <div class="col-md-7 my-auto">
                    <h2 class="featurette-heading">Efentivně <span class="text-muted">Chytré plánování </span></h2>
                    <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
                </div>
                <div class="col-md-5">
                    <i class="fas fa-business-time fa-10x"></i>
                </div>
            </div>


            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active w-50" id="nav-reg-tab" data-toggle="tab" href="#reg" role="tab" aria-controls="reg" aria-selected="true"><?php echo $web->getConf("regHeading");?></a>
                    <a class="nav-item nav-link w-50" id="nav-log-tab" data-toggle="tab" href="#log" role="tab" aria-controls="log" aria-selected="false"><?php echo $web->getConf("logHeading");?></a>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade show active" id="reg" role="tabpanel" aria-labelledby="nav-reg-tab">
                    <div class="row">
                        <div class="col-sm-6 mx-auto mt-2">
                            <form method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-at"></i> </span>
                                        </div>
                                        <input class="form-control" placeholder="<?php echo $web->getConf("regMail");?>" type="email" name="email" required>
                                    </div>
                                </div>
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
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="<?php echo $web->getConf("regFirstName");?>" type="text" name="firstName" required>
                                        <input type="text" class="form-control" placeholder="<?php echo $web->getConf("regLastName");?>" type="text" name="lastName" required>
                                    </div>
                                </div>
                                <div class="form-group custom-control custom-checkbox custom-control-inline">
                                    <input class="custom-control-input ng-untouched ng-pristine ng-invalid" name="privaci" id="cr1" type="checkbox" required>
                                    <label class="custom-control-label" for="cr1"><?php echo $web->getConf("regAcceptPolicy");?></label>
                                </div>
                                <button class="btn btn-lg btn-primary btn-block" type="submit"> <?php echo $web->getConf("regButton");?></button>
                            </form>
                        </div>
                    </div>  
                </div>

                <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="nav-log-tab">
                    <div class="row">
                        <div class="col-sm-6 mx-auto mt-2">
                        <form class="form-signin" method="POST">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo $web->getConf("mail");?>" type="email" name="login" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="<?php echo $web->getConf("password");?>" type="password" name="password" required>
                                </div> 
                            </div>
                            
                            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $web->getConf("logButton");?></button>
                            <a class="m-3 aligen-midle text-center" href="forget.php"><?php echo $web->getConf("forgetButton");?></a>
                        </form>
                        </div>
                    </div>  
                </div>

            </div>

        </div>
    </div>  
</body>

</html>
