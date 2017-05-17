<?php 
class Comments{

	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}


	public function post_profile_comment($employee_name, $comment, $user_id, $profile_opinion){

		$time = time();

		$query 	= $this->db->prepare("INSERT INTO `profile_comments` (`employee_name`, `profile_comment`, `profile_comment_time`, `user_id`, `profile_opinion`) VALUES (?,?,?,?,?) ");

		$query->bindValue(1, $employee_name);
		$query->bindValue(2, $comment);
		$query->bindValue(3, $time);
		$query->bindValue(4, $user_id);
		$query->bindValue(5, $profile_opinion);

		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}


}
