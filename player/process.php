<?php

include '../core/init.php';


$action = $_POST["action"];
for ($i = 1; $i <= 10; $i++) {
if($action == "showcomment".$i){
  $video_id = $_POST["video_id"];
      $query = $db->prepare("SELECT * FROM video_comments WHERE video_id = '$video_id' ORDER BY video_comment_id DESC");
      $query->execute();
 
     while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="comment">
                <div class="name">'.$row['employee_name'].'</div>
                <div class="date">Added on '.date('F j, Y',$row['video_comment_time']).' at '.date('h:i A',$row['video_comment_time']).'</div>
                <p>'.$row['video_comment'].'</p>
                <span>Reply: '.$row['video_opinion'].'</span>
            </div>
        ';
      }
  } else if($action == "addcomment".$i){
    $name = $_POST['name'.$i];
    $message = $_POST['message'.$i];
    $video_id = $_POST['video_id'];
    $user_id = $_POST['user_id'];
    $video_opinion = $_POST['video_opinion'.$i];
    $time = time();
     $query = $db->prepare("INSERT INTO video_comments(user_id, employee_name, video_comment, video_id, video_opinion, video_comment_time) values('$user_id','$name','$message', '$video_id', '$video_opinion', '$time') ");
     $query->execute();
 
     if($query){
        echo "Your comment has been sent";
     }
     else{
        echo "Error in sending your comment";
     }
  }
}
?>