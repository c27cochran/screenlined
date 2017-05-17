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
      <li><a href="company-home"><img src="images/logo.png"/></a></li>
      <?php 
 
  if($general->company_logged_in()){?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Company Profile <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="company-profile?company=<?php echo $company['company_id'];?>">Company Profile</a></li>    
      <li><a href="company-settings">Edit Company Profile</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Jobs<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="applicants">Applicants</a></li>
      <li><a href="company-jobs">Job Listings</a></li>
      <li><a href="post-job">Post Jobs</a></li>
        </ul>
      </li>
      <li class="col-xs-5 col-sm-3" style="width: 30%; padding-top: 15px;">
          <div class="input-group">
            <input type="text" id="search" class="form-control" placeholder="Search by Skills, City, or Name" name="srch-term" autocomplete="off">
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
      <li><a href="mailto:carter@screenlined.com?subject=Account%20Request">Request Account</a></li>
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
<script type="text/javascript" src="js/search.js"></script>