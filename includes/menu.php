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
      <li><a href="index"><img src="images/logo.png"/></a></li>
      <?php 
 
  if($general->logged_in()){?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="profile?user=<?php echo $user['user_id'];?>">View Profile</a></li>
      <li><a href="settings">Edit Profile</a></li>
      <li><a href="pending-applications?user=<?php echo $user['user_id'];?>">Application Status</a></li>
      <li><a href="change-password">Change password</a></li>
        </ul>
      </li>
      <li><a href="job-list">Job Openings</a></li>
      <li class="col-xs-5 col-sm-3" style="width: 30%; padding-top: 15px;">
          <div class="input-group">
            <input type="text" id="company-search" class="form-control" placeholder="Search Companies" name="srch-term" autocomplete="off">
            <ul class="dropdown-menu" id="results"></ul>
            <div class="input-group-btn">
              <span class="btn btn-default search-hover"><span class="glyphicon glyphicon-search"></span></span>
            </div>
          </div>
      </li>
      <li class="nav navbar-nav navbar-right"><a href="logout">Log out</a></li>
    </ul>
   
    <ul class="nav navbar-nav navbar-right">    
      
      <?php
  }else{?>
      <li><a href="mailto:carter@screenlined.com?subject=Account%20Request">Request an Account</a></li>
    <li><a href="login">Login</a></li>
    <li><a href="company-login">Company Login</a></li>
      <?php
  }
  ?>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

  </div>
</div>
<script type="text/javascript" src="js/company-search.js"></script>