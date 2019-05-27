<nav class="navbar navbar p-0" role="navigation">
      

      
        <button class="navbar-toggler bg-dark" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-align-justify text-light"></i>
        </button>

        <button class="navbar-toggler bg-dark float-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <i class="far fa-user text-light"></i>
         <!--<img src="/docs/4.2/assets/brand/bootstrap-solid.svg" width="30" height="30" alt="">-->
        </button>



</nav>

<div class="collapse navbar-collapse" id="navbarNav">
  <ul class="ml-auto navbar-nav navbar-right">
      <?php
      if(isset($_SESSION['id'])){
      ?>  
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="/teacher"><?php echo $web->getConf("menuImTeacher");?></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/?logout=true"><?php echo $web->getConf("menuLogOut");?></a>
          </div>
        </li>
      <?php
      }else{
      ?>   
        <li class="nav-item">
          <a class="btn btn-outline-primary m-1" href="/login" role="button">
              <?php echo $web->getConf("menuLogin");?>
          </a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-primary m-1" href="/login/registration.php" role="button">
              <?php echo $web->getConf("menuRegistr");?>
          </a>
        </li>
      <?php
      }
      ?>  
  </ul>
</div>