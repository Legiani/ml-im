<?php
    /*
	* Autoloader
	*/
	spl_autoload_register(function ($class_name) {
        include './class/'.$class_name . '.php';
    });

	// Load base class
    $web = new base();

    if(isset($_GET["id"])){
        $teacher = $web->getTeacher($_GET["id"]);
        $langs = $web->getTeacherLangs($teacher["id"]);
        $tags = $web->getTeacherTags($teacher["id"]);
    }
?>

<!DOCTYPE html>
<html lang="cz">
    <?php
        include_once(__DIR__."/themes/head.php");
    ?>
    <body class="text-center">
        <?php
            include_once(__DIR__."/themes/nav.php");
        ?>    
        <div class="container">
            <div class="col-12 bg-info mt-2 cityImage" style="background-image:linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url('/assets/img/city/<?php echo $langs[0]["lang"];?>.jpg')">
                <div class="col-md-3 mx-auto">
                    <img src="data:image/png;base64, <?php echo $teacher['photo']?>" class="rounded-circle mw-100 p-3" alt="Profile photo" />
                    <p class="text-center text-uppercase font-weight-bold mb-0"><?php echo $teacher['firstName']." ".$teacher['lastName']?></p>
                    <p class="text-center text-uppercase pb-3"><?php echo $teacher['price']."Kč/h"?></p>

                </div>
            </div>
            <div class="row">
                <div class="col-9">
                    <div class="p-2 bg-light d-flex my-auto">
                        <div class="col-md-4">
                            <?php
                                if($teacher['sex'] == "m"){
                                    echo '<i class="fas fa-male fa-2x"></i> <p>Můž</p>';
                                }else{
                                    echo '<i class="fas fa-female fa-2x"></i> <p>Žena</p>';
                                }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                            <?php
                                echo '<p>'.$teacher["city"]."</p>";
                            ?>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-clock fa-2x"></i>
                            <p>0</p>
                        </div>
                    </div>
                    <div class="mt-3 p-2 bg-light">
                        <h3><?php echo $web->getConf("detailAbout");?></h3>
                        <p><?php echo $teacher["about"];?><p>
                    </div>
                    <div class="mt-3 p-2 bg-light">
                        <h3><?php echo $web->getConf("detailKeywords");?></h3>
                        <?php
                            foreach($tags as $tag){
                                
                                echo '<a href="/?tag='.$tag["tag"].'"><span class="badge badge-info m-2">'.$tag["tag"].'</span></a>';
                            }
                        ?>
                    </div>
                    <div class="mt-3 p-2 bg-light">
                        <h3><?php echo $web->getConf("detailLanguage");?></h3>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                <th scope="col"></th>
                                <th scope="col">Jazyk</th>
                                <th scope="col">Uroven</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($langs as $key => $lang){
                                    echo '<tr>
                                        <th scope="row"><img src="/assets/img/flag/'.$lang["lang"].'.png" class="img-fluid" alt="flag"></th>
                                        <td>'.$lang["lang"].'</td>
                                        <td>'.$lang["levl"].'</td>
                                    </tr>
                                    ';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-3">
                    <div class="bg-light p-2">
                        <h4>Dotaz:</h4>
                        <div class="form-group">
                            <input type="text" class="form-control" name="from" placeholder="Váš email">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="content" placeholder="Znení dotazu" rows="7"></textarea>
                        </div>
                        <button type="button" class="btn btn-outline-warning btn-lg btn-block">Odeslat</button>
                    </div>

                    <div class="bg-light mt-2 p-2">
                        <h4>Rezervace:</h4>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datetimepicker1').datetimepicker({
                                    locale: 'cz',
                                    format: 'L',
                                    minDate: new Date()
                                });
                            });
                        </script>
                        <button type="button" class="btn btn-outline-warning btn-lg btn-block">Rezervovat</button>
                    </div>
                </div>
            </div>   
        </div>  
    </body>
</html>