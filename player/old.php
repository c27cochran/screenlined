<?php 
include '../core/init.php';

if(isset($_GET['user_id']) && empty($_GET['user_id']) === false) { // Putting everything in this if block.
 
    $user_id   = htmlentities($_GET['user_id']); // sanitizing the user inputed data (in the Url)
    $job_id   = htmlentities($_GET['job_id']);

    $profile_data   = array();
    $profile_id        = $users->fetch_info('user_id', 'user_id', $user_id);
    $profile_data   = $users->userdata($profile_id);

    $application_data   = array();
    $app_id        = $applications->applications_fetch_info('user_id', 'job_id', $user_id);
    $application_data   = $applications->applicationdata($user_id, $job_id);

    $job_data   = array();
    $position_id    = $jobs->jobs_fetch_info('job_id', 'job_id', $job_id);
    $job_data   = $jobs->jobdata($position_id);    
}

    $applicant_name = $profile_data['first_name']. ' ' .$profile_data['last_name'];
    ?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="flowplayer-3.2.13.min.js"></script>
    <?php include '../includes/bootstrap.php'; ?>
    
    <!-- page title -->
    <title>Screenlined</title>

</head>

<body>

<img src="../logo.png" />
    <div id="page">
        <?php include 'includes/company-menu.php';?>
        <h2>Candidate: <?php echo $applicant_name;?></h2>
        <hr>

        <div id="wowza" style="width:500px;height:320px;margin:20px auto;"></div>
 

<script type="text/javascript">
    $f("wowza", "http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf", {
 
    clip: {
        url: 'mp4:c27cochran/exxon/20/question_1.mp4',
        scaling: 'fit',
        // configure clip to use hddn as our provider, referring to our rtmp plugin
        provider: 'hddn'
    },
 
    // streaming plugins are configured under the plugins node
    plugins: {
 
        // here is our rtmp plugin configuration
        hddn: {
            url: "flowplayer.rtmp-3.2.13.swf",
 
            // netConnectionUrl defines where the streams are found
            netConnectionUrl: 'rtmp://54.209.139.207/play'
        }
    },
    canvas: {
        backgroundGradient: 'none'
    }
});
</script>


<!-- begin htmlcommentbox.com 
 <div id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">HTML Comment Box</a> is loading comments...</div>
 <link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
 <script type="text/javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"), l=(hcb_user.PAGE || ""+window.location), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&opts=16862&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); </script>
<!-- end htmlcommentbox.com -->

<!-- <hr>
<div id="vc-recommend-iframe-wrapper" style="height:300px"></div>
<div id="vc-comments-iframe-wrapper"></div>
<script type="text/javascript" src="http://api.vicomi.com/embed/widgets.js?access_token=ca95bb4b43c07faae35fabe5d95e561a"></script> -->

        
    </div>
    
    &copy;Screenlined 2014
</body>
</html>
