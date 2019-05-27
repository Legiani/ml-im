<?php
/*
	* Autoloader
	*/
	spl_autoload_register(function ($class_name) {
    include '../class/'.$class_name . '.php';
  });

	// Load base class
  $web = new base();

  if (isset( $_GET['confirm'], $_GET['key'])){
    if($web->regVerification($_GET['confirm'], $_GET['key'])){
      header('Location: /');
    }else{
      echo "neco se pokazilo";
    }
  }
?>

