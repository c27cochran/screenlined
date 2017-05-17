<?php
    session_start();
    include 'core/init.php';
    // $general->logged_out_protect();

    $config['base_url']             =   'http://www.screenlined.com/auth.php';
    $config['callback_url']         =   'http://www.screenlined.com/li-profile.php';
    $config['linkedin_access']      =   '75ov5dsz65sqzc';
    $config['linkedin_secret']      =   'LhFZfTuuBjJlyElY';

    include_once "linkedin.php";
   
    
    # First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
    $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
    //$linkedin->debug = true;

   if (isset($_REQUEST['oauth_verifier'])){
        $_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];

        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->getAccessToken($_REQUEST['oauth_verifier']);

        $_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
        header("Location: " . $config['callback_url']);
        exit;
   }
   else{
        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
   }


    # You now have a $linkedin->access_token and can make calls on behalf of the current member
    $xml_response = $linkedin->getProfile("~:(id,public-profile-url,first-name,last-name,picture-url,headline,educations,date-of-birth,location,specialties,main-address,summary,positions,languages,phone-numbers,industry,network,email-address)");  

    // echo '<pre>';
    // echo 'My Profile Info';
    // echo $xml_response;
    // echo '<br />';
    // echo '</pre>';

    $data = simplexml_load_string($xml_response);

    // if(isset($_GET['user']) && empty($_GET['user']) === false) { // Putting everything in this if block.
 
    // $email   = $user['email']; // sanitizing the user inputed data (in the Url)
    // if ($users->email_exists($email) === false) { // If the user doesn't exist
    //     header('Location:index'); // redirect to index page. Alternatively you can show a message or 404 error
    //     die();
    // }else{
    //     $profile_data   = array();
    //     $user_id        = $users->fetch_info('user_id', 'email', $email); // Getting the user's id from the email in the Url.
    //     $profile_data   = $users->userdata($user_id);
    // }

    // } 
 
?>

<!doctype html>
    <html lang="en">
    <head>  
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <script type="text/javascript" src="player/flowplayer-3.2.13.min.js"></script>
        <?php include 'includes/bootstrap.php'; ?>
        <title><?=$data->{'first-name'}?> <?=$data->{'last-name'}?>'s Profile</title>
    </head>
    <body>
    <!-- <span class="background-fade"></span> -->
    <?php include 'includes/menu.php'; ?>
    <div id="wrap">
    <div class="container container-white">
    


      <div class="row marketing">

        <div class="col-lg-8">
            <div class="userProfileHeader">
              <div>
                <h1><img src="<?=$data->{'picture-url'}?>" alt="profile" />&nbsp;<?=$data->{'first-name'}?> <?=$data->{'last-name'}?></h1>
              </div>

              <?php

                    if(!empty($profile_data['video_cover_letter_location'])){?> 
                    <div id="video-cover-letter">

                        <!-- Button trigger modal-->
                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                                Video Cover Letter
                        </button>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo $profile_data['first_name'].' '.$profile_data['last_name'];?></h4>
                                </div>
                                <div class="modal-body">
                                    <div id="video-cover-letter-player" style="width:500px;height:320px;margin:20px auto;"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                                    </div>
                                </div>
                        </div>

                        <script>
                        $f("video-cover-letter-player", "player/flowplayer-3.2.18.swf", {
                            plugins: {
                                rtmp: {
                                    url: "player/flowplayer.rtmp-3.2.11.swf",
                                    // netConnectionUrl: 'rtmp://localhost:1935/hdfvr_play/'
                                    netConnectionUrl: 'rtmp://54.209.139.207:1935/play/'
                                },

                                // default controls with the same background color as the page background
                                controls:  {
                                    backgroundColor: '#254558',
                                    backgroundGradient: 'none',
                                    all:false,
                                    mute:true,
                                    volume:true,
                                    play:true,
                                    pause:true,
                                    stop:true,
                                    height:30,
                                    progressColor: '#6d9e6b',
                                    bufferColor: '#333333',
                                    autoHide: false
                                },

                                // time display positioned into upper right corner
                                time: {
                                    url: "player/flowplayer.controls-3.2.16.swf",
                                    top:0,
                                    backgroundGradient: 'none',
                                    backgroundColor: 'transparent',
                                    buttonColor: '#254558',
                                    all: false,
                                    time: true,
                                    height:40,
                                    right:30,
                                    width:100,
                                    autoHide: false
                                }
                            },
                            clip: {
                                url: "mp4:<?php echo $profile_data['video_cover_letter_location']; ?>",
                                provider: "rtmp",
                                scaling: "fit",
                                autoPlay: false
                            },

                            // canvas coloring and custom gradient setting
                            canvas: {
                                backgroundColor:'#254558',
                                backgroundGradient: [0.1, 0]
                            }
                        });
                        </script>
                    </div>
                    <?php 
                        } 
                        ?>
            </div><!-- /userProfileHeader -->
            <h3><?=$data->headline?></h3>

            <div class="row">
                <div class="col-xs-6">
                <div id="personal_info">

                    <h4>Education</h4>
                    <?=$data->educations->education->{'school-name'}?><br>
                    <?=$data->educations->education->degree?><br>
                    <?=$data->educations->education->{'field-of-study'}?><br>
                    <?=$data->educations->education->{'start-date'}->year?> - <?=$data->educations->education->{'end-date'}->year?><br>

                    <h4>Location</h4>
                    <span><?=$data->location->name?></span>
                    <br>

<!--                         <h4>Resume</h4>

                            <a href="<?php echo $profile_data['resume_location']; ?>" target="_blank">View Resume</a>
-->
                            <br>
                            <a href="<?=$data->{'public-profile-url'}?>" target="_blank">LinkedIn Profile</a></span>
                            <br>

                    </div>
                </div><!-- 6 -->

                <div class="col-xs-6">
                  <div id="pending-applications">
                    <h4>Application Status</h4>
                    <?php 

                        $query = $db->prepare("SELECT j.job_title, a.job_id, a.application_status, c.company_name FROM jobs j join applications a on j.job_id = a.job_id join company c on j.company_id = c.company_id where a.user_id = ?");
                        $query->bindValue(1, $user_id);
                        $query->execute();

                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo '<p>'.$row['job_title'].' at '.$row['company_name'].': <b>'.$row['application_status'].'</b></p>';
                            }

                            if (!empty($row['job_title'])) { ?>
                                <h4>Application Status</h4>
                     <?php }

                    ?>

                    </div>  
                </div><!-- 6 -->
            </div><!-- /row -->
            
            <div class="userDescription">   
                <h4 class="cover-letter">Summary</h4>
                <span><?=$data->summary?></span>
            </div><!-- /userDescription -->
            </div><!-- /col-md-8 -->


      </div>

    </div> <!-- /container -->
</div>

      <!-- FOOTER -->
      <?php include 'includes/footer.php'; ?>
    </body>
    </html>