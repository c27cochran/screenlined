<div class="navbar-wrapper">
  <div class="nav-container">

        <nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a href="#"><img src="../images/logo.png"/></a></li>
      <?php 
 
  if($general->logged_in()){?>

    </ul>
   
    <ul class="nav navbar-nav navbar-right">
      
    <li><a href="../logout">Log out</a></li>
        
      
      <?php
  }else{?>
      <li><a href="mailto:carter@screenlined.com?subject=Account%20Request">Request an Account</a></li>
    <li><a href="../login">Login</a></li>
    <li><a href="../company-login">Company Login</a></li>
      <?php
  }
  ?>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

  </div>
</div>