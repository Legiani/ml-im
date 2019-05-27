<?php
/*
 * Autoloader
 */
spl_autoload_register(function ($class_name) {
    include '../class/' . $class_name . '.php';
});

// Load base class
$web = new base();


if (isset( $_POST['contactEmail'], $_POST['phone'], $_POST['age'])){
    //Imput control picture
    if(empty($_FILES['photo']['tmp_name']) || empty($_FILES['photo']['size'])){    
        echo "chyba obrazku";
        exit();
    }else{
        $data = file_get_contents($_FILES['photo']['tmp_name']);
        $image = base64_encode($data);
    }

    if($web->teacherRegistr($_POST, $image)){
        //header("Location: /teacher");
    }else{
        echo "chyba ukládání";
    }
    
}

echo "<pre>"; print_r($_POST); echo "</pre>";

?>

<!doctype html>
<html lang="cz" class="h-100">
    <?php
        include("../themes/head.php");
    ?>
    <body class="text-center h-100">
        <!-- Multistep form -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <link href="/assets/css/multistepForm.css" type="text/css" rel="stylesheet" />
        <script src="/assets/js/multistepForm.js"></script>
        <link href="/assets/css/jquery-tagsinput.min.css" type="text/css" rel="stylesheet" />
        <script src="/assets/js/jquery-tagsinput.min.js"></script>

    
        <?php
        include("../themes/nav.php");
        ?>    
            <!-- MultiStep Form -->
        <div class="container-fluid bg-info" id="mainScreen">
            <section class="m-0 row h-100" id="background">
                <div class="col-sm-4 mx-auto my-auto bg-white m-2 p-2">
                    <form id="regForm" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                        <!-- One "tab" for each step in the form: -->
                        <div class="tab">
                            <h3><?php echo $web->getConf("fgeneral");?></h3>   
                            <!-- E-mail -->
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $web->getConf("fcontactMail");?></label>
                                <input type="text" class="form-control"  name="contactEmail" placeholder="E-mail">
                            </div>
                            <!-- Phone -->
                            <div class="form-group row">
                                <label for="exampleInputEmail1" class="col-6"><?php echo $web->getConf("fcontactPhone");?></label>
                                <div class="col-6">
                                    <input type="text" class="form-control"  name="phone" placeholder="Telefon" value="+420">
                                </div>    
                            </div>
                            <!-- Age -->
                            <div class="form-group row">
                                <label for="exampleInputEmail1" class="col-6"><?php echo $web->getConf("fage");?></label>
                                <div class="col-6">
                                    <input type="text" class="form-control"  name="age" placeholder="22">
                                </div>    
                            </div>
                            <!-- Gender -->
                            <div class="control-group row">
                                <label class="control-label  col-6" for="gender"><?php echo $web->getConf("fgender");?></label>
                                <div class="controls  col-6">
                                    <label class="radio inline" for="gender-0">
                                    <input name="sex" value="m" type="radio">
                                    <?php echo $web->getConf("fman");?>
                                    </label>
                                    <label class="radio inline" for="gender-1">
                                    <input name="sex" value="f" type="radio">
                                    <?php echo $web->getConf("fwoman");?>
                                    </label>
                                </div>
                            </div>

                            <!-- Photo --> 
                            <div class="control-group">
                                <label class="control-label" for="photo"><?php echo $web->getConf("fphoto");?></label>
                                <div class="controls">
                                    <input name="photo" class="image" type="file">
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h3><?php echo $web->getConf("flanguage");?></h3>
<!-- https://bootsnipp.com/snippets/AXVrV -->
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="mainSelect"><?php echo $web->getConf("fchoiceLanguage");?></label>
                                    <select class="form-control" id="mainSelect" name="slectLang[]">
                                        <option value="GB">AJ - UK</option>
                                        <option value="GB">AJ - US</option>
                                        <option value="DK">NJ</option>
                                        <option value="FR">FR</option>
                                        <option value="ES">SP</option>
                                        <option value="RU">RU</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="mainSelect"><?php echo $web->getConf("fchoiceLevl");?></label>
                                    <select class="form-control" id="mainSelect" name="slectLevl[]">
                                        <option><?php echo $web->getConf("fnoCerificate");?></option>
                                        <option>A1</option>
                                        <option>A2</option>
                                        <option>B1</option>
                                        <option>B2</option>
                                        <option>C1</option>
                                        <option>C2</option>
                                    </select>
                                </div>
                            </div> 
                            <div id="setLang"></div> 

                            <div class="mx-auto">
                                <button type="button" class="btn btn-outline-primary" id="removeField" onclick="remove()"><?php echo $web->getConf("fdelLang");?></button>
                                <button type="button" class="btn btn-outline-primary" id="addField" onclick="add()"><?php echo $web->getConf("faddLang");?></button>
                            </div>
                        </div>
                        
                        <div class="tab">
                            <h3><?php echo $web->getConf("fmyCircle");?></h3>
                            <div class="form-group text-white">
                            <input data-role='tags-input' value="Společnosti;Gramatika;Konverzace;Maminky;Děti;Studenti">
                            </div>
                        </div>

                        <div class="tab">
                            <div class="row mt-2">
                                <div class="form-group col-6">
                                    <h4><?php echo $web->getConf("fcity");?></h4>
                                    <select class="form-control" name="city">
                                        <option value="praha">Praha</option>
                                        <option value="brno">Brno</option>
                                        <option value="ostrava">Ostrava</option>
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <h4><?php echo $web->getConf("fprice");?></h4>
                                    <input type="text" class="form-control"  name="price" placeholder="300">
                                    <small><?php echo $web->getConf("fsmallInfo");?></small>
                                </div>
                            </div> 

                            <h3><?php echo $web->getConf("fabout");?></h3>
                            <div class="form-group">
                                <textarea class="form-control rounded-0" name="about" rows="3"></textarea>
                            </div>  
                        </div>
                        <div class="overflow-auto m-2">
                            
                            <button type="button" class="btn btn-outline-primary float-left" id="prevBtn" onclick="nextPrev(-1)"><?php echo $web->getConf("back");?></button>
                            <button type="button" class="btn btn-primary float-right" id="nextBtn" onclick="nextPrev(1)"><?php echo $web->getConf("next");?></button>
                            
                        </div>
                        <!-- Circles which indicates the steps of the form: -->
                        <div class="text-center m-4">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>

                        </div>
                    </form>
                    <div class="dme_link">
                        <small><?php echo $web->getConf("allVisible");?></small>
                    </div>
                </div>
            </section>    
            <!-- /.MultiStep Form -->
        </div>  
    </body>
</html>
