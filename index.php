<?php 
require 'core/init.php';
// $general->logged_out_protect();
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easiest and best video interview software. We're proud to be an Austin startup revolution! Screenlined - Screenlined.com">
    <meta name="author" content="screenlined.com">

    <title>Video Interviews - Screenlined.com</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
    
  </head>
<!-- NAVBAR
================================================== -->
  <body>
    <div class="navbar-wrapper">
      <div class="container">

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
    </ul>
   
    <ul class="nav navbar-nav navbar-right">
      
    <li><a href="logout">Log out</a></li>
        
      
      <?php
  }elseif($general->company_logged_in()){?>
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
     <?php } else {?>
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


    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img data-src="holder.js/900x500/auto/#777:#7a7a7a/text:First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Post a job</h1>
              <p>Create a custom job post using our revolutionary software.</p>
              <!-- <p><a class="btn btn-lg btn-primary" href="mailto:carter@screenlined.com?subject=Account%20Request" role="button">Request an Account</a></p> -->
            </div>
          </div>
        </div>
        <div class="item">
          <img data-src="holder.js/900x500/auto/#666:#6a6a6a/text:Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Invite Candidates</h1>
              <p>Invite those with potential to respond to interview questions via web cam.</p>
              <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
            </div>
          </div>
        </div>
        <div class="item">
          <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Watch Their Videos</h1>
              <p>Watch their responses, make notes. Collaborate when you want, where you want. Easy, efficient, streamlined.</p>
              <!-- <p><a class="btn btn-lg btn-primary" href="#first-featurette" role="button">Can you believe these stats?</a></p> -->
            </div>
          </div>
        </div>
        <div class="item">
          <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Trim the List</h1>
              <p>Trim down potential to final few candidates while respectfully keeping them in the loop every step of the way. Your rockstars can schedule their final in person interviews through our calendar with pre-approved time slots you chose.</p>
              <!-- <p><a class="btn btn-lg btn-primary" href="#first-featurette" role="button">Can you believe these stats?</a></p> -->
            </div>
          </div>
        </div>
        <div class="item">
          <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Hire</h1>
              <p>Hire better quality. Saving time, money, and sanity. Boom. Screenlined.</p>
              <p><a class="btn btn-lg btn-primary" href="mailto:carter@screenlined.com?subject=I%20Want%20Screenlined!" role="button">Learn More</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->

    <div style="text-align:center;">
        <h1>Streamlining the Screening Process</h1>
    </div>
    <br>
    <hr>

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

<!-- 
      <div class="row">
        <div class="col-lg-4">
          <img class="search" src="images/job-search.png" alt="job search">
          <h2>Our Mission</h2>
          <p>Screenlined is out to create a more enjoyable hiring/application process for both candidates and hiring managers through an efficient software that saves time for both parties, organizes all hiring needs and information 
            in one place, and gives companies a chance to see the full picture of each candidate - not just a resume.</p>
          <p><a class="btn btn-default" href="mailto:carter@screenlined.com?subject=Account%20Request" role="button">Request Account &raquo;</a></p>
        </div>
        <div class="col-lg-4">
          <img class="questions" src="images/interview-questions.png" alt="questions">
          <h2>What We Do</h2>
          <p>Your company has the ability to search for or invite candidates that meet the criteria for an open position. Candidates will create video responses to your custom questions. Your team can then simply watch video responses and 
            choose whether or not to progress towards the next stage of the hiring process. 
            You can choose pre-programmed or customized questions. Responses to candidates can be sent through the click of a button.</p>
          <p><a class="btn btn-default" href="#first-featurette" role="button">Why This Matters &raquo;</a></p>
        </div>
        <div class="col-lg-4">
          <img class="comment" src="images/calendar.png" alt="calendar">
          <h2>We Make it Easy</h2>
          <p>All hiring needs are found in one place and there is no need for constant back and forth communication with candidates. Our software is simple to use, but powerful. 
            Screenlined has multiple customized options that can be tailored for any company's needs. HR departments, managers and teams will be able to share videos and notes seamlessly to streamline the hiring process.</p>
          <p><a class="btn btn-default" href="mailto:carter@screenlined.com?subject=Learn%20More" role="button">Learn More &raquo;</a></p>
        </div>
      </div>
 -->
      <br>

      <div class="row">
        <div class="col-md-2 col-md-offset-1">
          <img src="images/post.png" alt="post a job" width="75">
          <h2>Post</h2>
        </div>
        <div class="col-md-2">
          <img src="images/invite.png" alt="invite" width="70">
          <h2>Invite</h2>
        </div>
        <div class="col-md-2">
          <img src="images/play.png" alt="watch interviews" width="75">
          <h2>Watch</h2>
        </div>
        <div class="col-md-2">
          <img src="images/trim.png" alt="trim the list" width="75">
          <h2>Trim</h2>
        </div>
        <div class="col-md-2">
          <img src="images/hire.png" alt="hire" width="75">
          <h2>Hire</h2>
        </div>
      </div>

      <br>
      <br>
      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">


      <div class="row featurette" id="first-featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">A stunning 60 percent of candidates say they've gone for interviews and never heard back from the company.<span class="text-muted">This is what Screenlined does.</span></h2>
          <p class="lead">We make it easy for your company to communicate with applicants with the push of a button, keeping your applicants in the loop and saving you time.</p>
        </div>
        <div class="col-md-5">
        </div>
      </div>
      

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">75 percent of candidates never hear back from a company after sending in an application.<span class="text-muted">This is where Screenlined saves you time.</span></h2>
          <p class="lead">It's worth noting that a negative candidate experience isn't just limited to grueling interviews. With Screenlined, we use timed, online video interviews to save you and your applicants time and money. Choose which candidates fit your team best, watch their pre-recorded interviews and get the best talent on board faster.</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">42 percent of disgruntled candidates will not apply for a position at the company again.<span class="text-muted">This is why you need Screenlined.</span></h2>
          <p class="lead">That's a massive opportunity cost to your company. There's a real chance that you'll never again see a candidate you happened to like a lot but might have been second or third runner-up in your selection process if they felt disrespected by the process.</p>
        </div>
        <div class="col-md-5">
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
        <p class="pull-right"><a href="#">Back to top</a></p>
        <?php include 'includes/footer.php'; ?>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
