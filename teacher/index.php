<?php
/*
 * Autoloader
 */
spl_autoload_register(function ($class_name) {
    include './../class/' . $class_name . '.php';
});

// Load base class
$web = new base();
if(!$_SESSION['id']){
    header('Location: /teacher/info.php');
}
else if(!$web->isTeacher()){
    header('Location: /teacher/form.php');
}
  $teacher = $web->getTeacher($_SESSION["id"]);
  $langs = $web->getTeacherLangs($_SESSION["id"]);
  $tags = $web->getTeacherTags($_SESSION["id"]);

  if(isset($_POST["date"], $_POST["timeFrom"], $_POST["timeTo"], $_POST["action"])){
  echo $web->addToCalendar($_POST["date"], $_POST["timeFrom"], $_POST["timeTo"], $_POST["action"]);
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
    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <img src="data:image/png;base64, <?php echo $teacher['photo']?>" class="rounded-circle mw-100 p-3" alt="Profile photo" />

                <span><?php echo $teacher['firstName']?> <?php echo $teacher['lastName']?></span>
                <span>Odučeno: 0</span>
                <div class="m-2">
                    <span class="fa fa-star text-warning"></span>
                    <span class="fa fa-star text-warning"></span>
                    <span class="fa fa-star text-warning"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </div>

                <div class="m-2">
                    <nav class="nav nav-pills nav-justified d-block">
                        <a class="nav-item nav-link <?php if(isset($_GET["profile"])){echo "active";}?> " href="?profile">Profil</a>
                        <a class="nav-item nav-link <?php if(empty($_GET)){echo "active";}?>" href=".">Kalendář</a>
                        <a class="nav-item nav-link <?php if(isset($_GET["students"])){echo "active";}?>" href="?students">Studenti</a>
                    </nav>
                </div>
            </div>
            <div class="col-md-10 mt-2">
                <?php
                    if(isset($_GET["profile"])){
                      include(__DIR__."/profile.php");
                    }elseif(isset($_GET["students"])){
                        
                    }else{
                      echo file_get_contents(__DIR__."/modal.php");
                      $web->getWeekCalendar();
                      echo "<script>";
                        print_r($web->getTeacherProgram());
                      echo "</script>";
                    }
                ?>
            </div>
        </div>    
    </div>
 
</body>

</html>
