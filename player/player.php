<?php 
include '../core/init.php';
$general->company_logged_out_protect();

if(isset($_GET['user_id']) && empty($_GET['user_id']) === false) { 
  
  if(isset($_GET['job_id']) && empty($_GET['job_id']) === false) {

    $user_id   = htmlentities($_GET['user_id']); // sanitizing the user inputed data (in the Url)
    $job_id   = htmlentities($_GET['job_id']);

    # Updating status to pending once an employee has viewed this page
    $status = 'Pending';
    $applications->set_status($status, $job_id, $user_id);

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
}

if (isset($_POST['accept-submit'])) {

        header('Location: ../accepted?accepted&user_id='.$user_id.'&job_id='.$job_id);
        exit();
}

if (isset($_POST['deny-submit'])) {

        header('Location: ../denied?denied&user_id='.$user_id.'&job_id='.$job_id);
        exit();
}

    $applicant_name = $profile_data['first_name']. ' ' .$profile_data['last_name'];
    ?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="flowplayer-3.2.13.min.js"></script>
    <?php include 'includes/bootstrap.php'; ?>
    
    <!-- page title -->
    <title>Screenlined</title>

</head>

<body>
    <?php include 'includes/company-menu.php';?>
    <div id="wrap">
    <div class="container container-white">
        <div class="jumbotron">
            <h2>Candidate: <?php echo $applicant_name;?></h2>
        </div>

    <h3>Your team's responses:</h3>
    <div id="negative-responses">
        <h4>Negative: 

            <?php 

                $query = $db->prepare("SELECT
                    (SELECT COUNT(*) FROM video_comments WHERE video_opinion = 'No' and user_id = ?) +
                    (SELECT COUNT(*) FROM profile_comments WHERE profile_opinion = 'No' and user_id = ?) AS no");
                $query->bindValue(1, $user_id);
                $query->bindValue(2, $user_id);
                $query->execute();

                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo "<span>" . $row['no'] . "</span>";                     
                }               
            ?>
        </h4>
    </div>
    <div id="positive-responses">
        <h4>Positive: 

            <?php 

                $query = $db->prepare("SELECT
                    (SELECT COUNT(*) FROM video_comments WHERE video_opinion = 'Yes' and user_id = ?) +
                    (SELECT COUNT(*) FROM profile_comments WHERE profile_opinion = 'Yes' and user_id = ?) AS yes");
                $query->bindValue(1, $user_id);
                $query->bindValue(2, $user_id);
                $query->execute();

                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo "<span>" . $row['yes'] . "</span>";                        
                }               
            ?>
        </h4>
    </div>
        
        <div id="question-list">
<?php 

for ($i = 1; $i <= 10; $i++) {
    if (!empty($application_data['answer_'.$i.'_location'])) {
        $video_id = $application_data['answer_'.$i.'_location'];
?>
<p><?php echo $job_data['question_'.$i.''];?></p>
<!-- Button trigger modal -->
<button class="btn btn-primary btn-modal" data-toggle="modal" data-target="#myModal<?php echo $i;?>">
  See <?php echo $profile_data['first_name']?>'s Answer
</button>

<!-- Modal -->
<div class="modal fade" id="myModal<?php echo $i?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $applicant_name.': '.$job_data['question_'.$i.''];?></h4>
      </div>
      <div class="modal-body">
        <div id="question<?php echo $i;?>" style="width:500px;height:320px;margin:20px auto;"></div>
        <h4>Comments:</h4>
        <div id="addCommentContainer<?php echo $i;?>">
            <p>Add a Comment</p>
            <form id="commentForm<?php echo $i;?>" class="commentForm" method="post" action="">
                <div>
                    <label for="name">Your Name:</label>
                    <?php 
                        if(empty($_SESSION['employee_name'])) {?>

                            <input type="text" name="name" id="name<?php echo $i;?>" />    

                    <?php    
                        } else { ?>

                            <span><?php echo $_SESSION['employee_name'];?></span><br>
                            <input type="hidden" name="name" id="name<?php echo $i;?>" value="<?php echo $_SESSION['employee_name']?>" />
                    <?php 
                        }

                    ?>

                    <label for="body">Comment:</label>
                    <textarea name="message" id="message<?php echo $i;?>" cols="20" rows="5"></textarea>

                    <label>Do you think <?php echo $profile_data['first_name']; ?> be a good fit?</label>    
                    <br>
                    <select id="video_opinion<?php echo $i;?>" name="video_opinion">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>

                    <br>
                    <input type="button" id="button<?php echo $i;?>" class="btn btn-primary btn-sm btn-top" value="Submit" onclick="location.href ='#comments<?php echo $i;?>';" />
                </div>
            </form>
        </div>
        <div id="comments<?php echo $i;?>"></div>
<script>
$(document).ready(function(){
 
    function showComment<?php echo $i?>(){
        var video_id="<?php echo $video_id;?>";
        $.ajax({
        type:"post",
        url:"process.php",
        data:"action=showcomment<?php echo $i;?>&video_id="+video_id,
        success:function(data){
                $("#comments<?php echo $i;?>").html(data).insertBefore('#addCommentContainer<?php echo $i;?>');
        }
        });
    }
 
    showComment<?php echo $i?>();
 
 
    $("#button<?php echo $i?>").click(function(){
 
            var user_id = "<?php echo $user_id;?>";
            var name = $("#name<?php echo $i;?>").val();
            var message = $("#message<?php echo $i;?>").val();
            var video_id = "<?php echo $video_id;?>";
            var video_opinion = $("#video_opinion<?php echo $i;?>").val();
 
            $.ajax({
                type:"post",
                url:"process.php",
                data:"user_id="+user_id+"&name<?php echo $i;?>="+name+"&message<?php echo $i;?>="+message+"&video_id="+video_id+"&video_opinion<?php echo $i;?>="+video_opinion+"&action=addcomment<?php echo $i;?>",
                success:function(data){
                showComment<?php echo $i?>();
                                  
                }
 
            });
 
    });

});
</script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$f("question<?php echo $i;?>", "flowplayer-3.2.18.swf", {
    plugins: {
        rtmp: {
            url: "flowplayer.rtmp-3.2.11.swf",
            // netConnectionUrl: 'rtmp://localhost:1935/hdfvr_play/'
            netConnectionUrl: 'rtmp://54.209.139.207/play/'
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
            url: "flowplayer.controls-3.2.16.swf",
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
        url: "mp4:<?php echo $application_data['answer_'.$i.'_location']; ?>",
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
<?php
    }
}    
?>  
    <hr>

    <form method="post" action="" id="accept-deny-form">
        <input type="submit" name="accept-submit" value="Accept" class="btn btn-primary btn-lg" />
        <input type="submit" name="deny-submit" value="Deny" class="btn btn-primary btn-lg" style="float:right;"/>
    </form>

    <br>

    </div> <!-- /question-list -->
    </div> <!-- /container -->
    </div>

    <!-- FOOTER -->
    <?php include 'includes/footer.php'; ?>    
</body>
</html>
