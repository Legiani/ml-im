<?php
/*
	* Autoloader
	*/
	spl_autoload_register(function ($class_name) {
        include './class/'.$class_name . '.php';
    });

	// Load base class
    $web = new base();

    // Check login
    if(isset($_GET["logout"])){
        // remove all session variables
        if($web->logout()){
            header("Location: /");
        }
    }

    // Filter teachers
    if(isset($_GET["lang"], $_GET["city"], $_GET["price"])){
        $teachers = $web->getTeachers($_GET["lang"], $_GET["city"], null, $_GET["price"]);
    }else if (isset($_GET["tag"])){
        $teachers = $web->getTeachers(null, null, $_GET["tag"], $_GET["price"]);
    }else{
        $teachers = $web->getTeachers();
    }
?>

<!doctype html>
<html lang="cz" class="h-100">
    <?php
        include_once(__DIR__."/themes/head.php");
    ?>
    <body class="text-center h-100">
        <?php
            include_once(__DIR__."/themes/nav.php");
        ?>    
        <div class="container-fluid" id="mainScreen">
            <section class="m-0 row h-100" id="background">
                <div class="col-sm-12 my-auto">
                    <div class="">
                        <div class="row mb-4 mt-4">
                            <div class="col-9 mx-auto">
                                <h1><?php echo $web->getConf("mainHeading");?></h1>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-9 mx-auto">
                                <p class="h4"><?php echo $web->getConf("mainSubtitle");?></p>
                            </div>
                        </div>
                        <div class="row mx-auto mb-2">
                            <div class="col-6 mx-auto my-auto">
                                <a href="#" class="btn btn-dark btn-lg" role="button"><?php echo $web->getConf("studentButton");?></a>
                            </div>
                            <div class="col-6 mx-auto my-auto">
                                <a href="/teacher/info.php" class="btn btn-dark btn-lg" role="button"><?php echo $web->getConf("teacherButton");?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid bg-info p-3">
                <form class="form-inline" action="/" action="GET">
                    <div class="form-group mx-auto">
                        <label for="lang"><?php echo $web->getConf("filtrLang");?>:</label>
                        <select class="form-control ml-1" name="lang" title="lang">
                            <option value="GB">AJ GB </option>
                            <option value="US">AJ US</option>
                            <option value="DK">NJ</option>
                            <option value="ES">SP</option>
                            <option value="FR">FR</option>
                            <option value="RU">RU</option>
                        </select>
                    </div>

                    <div class="form-group mx-auto">
                        <label for="city"><?php echo $web->getConf("filtrCity");?>:</label>
                        <select class="form-control ml-2" name="city" title="city">
                            <option value="praha">Praha</option>
                            <option value="brno">Brno</option>
                            <option value="ostrava">Ostrava</option>
                            <option value="plzen">Plzeň</option>
                        </select>
                    </div>

                    <div class="form-group mx-auto my-auto">
                        <label for="price" class="mr-3"><?php echo $web->getConf("filtrPrice");?>:</label>
                        <select class="form-control ml-2" name="price" title="price">
                            <option value="ASC">přivětivé -> drahé</option>
                            <option value="DESC">drahý -> přivetivé</option>
                        </select>
                    </div>

                    <div class="form-group mx-auto">
                        <button type="submit" class="btn btn-primary"><?php echo $web->getConf("filtrButton");?></button>
                    </div>    
                </form>
                    
            </section>
            <div class="container" id="teachers">
                <?php
                    if($teachers){
                        foreach($teachers as $teacher){
                            echo '<a href="detail.php?id='.$teacher['id'].'"> <div class="col-2 m-3 p-2 bg-light d-inline-block">
                                    <div class="p-4">';
                                        echo '<img src="data:image/png;base64, '.$teacher['photo'].'" class="rounded-circle mw-100" alt="Red dot" />
                                    </div>';
                                    echo '<p class="text-center text-uppercase font-weight-bold text-dark">'.$teacher['firstName'].' '.$teacher['lastName'].'</p>';
                                    echo '<p class="text-center text-dark">'.$teacher['price'].' Kč/h</p>';
                            echo '</div>';
                        }
                    }else{
                        echo '<div class="m-3 p-3"><i class="fas fa-search fa-w-16 fa-7x m-2"></i><p>Tady zrovna nikoho nemáme :-(</p></div>';
                    }
                ?>  
            </div>
        </div>  
    </body>
</html>
