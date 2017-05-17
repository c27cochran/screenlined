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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Screenlined</title>

    <!-- Bootstrap core CSS -->
    <link href="/screenlined/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/screenlined/css/carousel.css" rel="stylesheet">
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
            <li><a href="profile?email=<?php echo $user['email'];?>">View Profile</a></li>
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
  }else{?>
      <li><a href="register">Register</a></li>
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
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img data-src="holder.js/900x500/auto/#777:#7a7a7a/text:First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Applicants...Get Noticed</h1>
              <p>Create your profile, search for the best jobs, answer some interview questions using your webcam and get hired!</p>
              <p><a class="btn btn-lg btn-primary" href="register" role="button">Sign up today</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img data-src="holder.js/900x500/auto/#666:#6a6a6a/text:Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Companies...Get the Best Talent</h1>
              <p>We're transforming the entire hiring process.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h1>Everyone Wins</h1>
              <p>With Screenlined, we make it easy to keep your applicants in the loop, but we also save you time and money. We know...it's hard to believe. Contact us to find out more.</p>
              <p><a class="btn btn-lg btn-primary" href="#first-featurette" role="button">Can you believe these stats?</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->



    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="search" src="images/job-search.png" alt="Generic placeholder image">
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="questions" src="images/interview-questions.png" alt="Generic placeholder image">
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="comment" src="images/comment.png" alt="Generic placeholder image">
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">


      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">A stunning 60 percent of candidates say they've gone for interviews and never heard back from the company.<span class="text-muted">This is what Screenlined does.</span></h2>
          <p class="lead">We make it easy for your company to communicate with applicants with the push of a button, keeping your applicants in the loop and saving you time.</p>
        </div>
        <div class="col-md-5">
        </div>
      </div>
      

      <hr class="featurette-divider">

      <div class="row featurette" id="first-featurette">
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
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&middot; &copy; 2013 Screenlined &middot; </p>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="/screenlined/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
