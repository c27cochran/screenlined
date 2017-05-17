<?php 
class Applications{

	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}		

	public function apply($job_id, $user_id, $company_id, $status) {

		$query 	= $this->db->prepare("INSERT INTO `applications` (`job_id`, `user_id`, `company_id`, `application_status`) VALUES (?,?,?,?)");

		$query->bindValue(1, $job_id);
		$query->bindValue(2, $user_id);
		$query->bindValue(3, $company_id);
		$query->bindValue(4, $status);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function application_exists($job_id, $user_id) {
	
		$query = $this->db->prepare("SELECT count(j.job_id) FROM jobs j join applications a on j.job_id = a.job_id WHERE j.job_id = ? and a.user_id = ?");
		$query->bindValue(1, $job_id);
		$query->bindValue(2, $user_id);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function set_status($status, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `application_status` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $status);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function deny_applicant($job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `application_status` = 'Denied' WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $job_id);
		$query->bindValue(2, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function accept_applicant($job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `application_status` = 'Accepted' WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $job_id);
		$query->bindValue(2, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function applications_fetch_info($what, $field, $value){

		$allowed = array('job_id', 'user_id', 'answer_1_location'); // I have only added few, but you can add more. However do not add 'password' eventhough the parameters will only be given by you and not the user, in our system.
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
		    throw new InvalidArgumentException;
		}else{
		
			$query = $this->db->prepare("SELECT $what FROM `applications` WHERE $field = ?");

			$query->bindValue(1, $value);

			try{

				$query->execute();
				
			} catch(PDOException $e){

				die($e->getMessage());
			}

			return $query->fetchColumn();
		}
	}

	public function applicationdata($user_id, $job_id) {

		$query = $this->db->prepare("SELECT * FROM `applications` WHERE `user_id`= ? and `job_id`= ?");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $job_id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}

	public function set_answer1($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_1_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer2($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_2_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer3($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_3_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer4($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_4_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer5($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_5_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer6($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_6_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer7($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_7_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer8($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_8_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer9($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_9_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function set_answer10($answer_location, $job_id, $user_id) {

		$query 	= $this->db->prepare("UPDATE `applications` SET `answer_10_location` = ? WHERE `job_id` = ? and `user_id` = ?");

		$query->bindValue(1, $answer_location);
		$query->bindValue(2, $job_id);
		$query->bindValue(3, $user_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}


}
