<?php 
class Jobs{

	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}		

	public function post_job($job_id, $company_id, $job_title, $job_description, $question_1, 
			$question_2, $question_3, $question_4, $question_5, $question_6, $question_7, 
			$question_8, $question_9, $question_10, $question_1_time, $question_2_time, 
			$question_3_time, $question_4_time, $question_5_time, $question_6_time, $question_7_time, 
			$question_8_time, $question_9_time, $question_10_time) {

		$query 	= $this->db->prepare("INSERT INTO `jobs` (`job_id`, `company_id`, `job_title`, `job_description`, 
			`question_1`, `question_2`, `question_3`, `question_4`, `question_5`, `question_6`, `question_7`, 
			`question_8`, `question_9`, `question_10`, `question_1_time`, `question_2_time`, `question_3_time`, 
			`question_4_time`, `question_5_time`, `question_6_time`, `question_7_time`, `question_8_time`, 
			`question_9_time`, `question_10_time`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		$query->bindValue(1, $job_id);
		$query->bindValue(2, $company_id);
		$query->bindValue(3, $job_title);
		$query->bindValue(4, $job_description);
		$query->bindValue(5, $question_1);
		$query->bindValue(6, $question_2);
		$query->bindValue(7, $question_3);
		$query->bindValue(8, $question_4);
		$query->bindValue(9, $question_5);
		$query->bindValue(10, $question_6);
		$query->bindValue(11, $question_7);
		$query->bindValue(12, $question_8);
		$query->bindValue(13, $question_9);
		$query->bindValue(14, $question_10);
		$query->bindValue(15, $question_1_time);
		$query->bindValue(16, $question_2_time);
		$query->bindValue(17, $question_3_time);
		$query->bindValue(18, $question_4_time);
		$query->bindValue(19, $question_5_time);
		$query->bindValue(20, $question_6_time);
		$query->bindValue(21, $question_7_time);
		$query->bindValue(22, $question_8_time);
		$query->bindValue(23, $question_9_time);
		$query->bindValue(24, $question_10_time);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function update_job($job_description, $job_id){

		$query = $this->db->prepare("UPDATE `jobs` SET `job_description` = ? WHERE `job_id` = ?");

		$query->bindValue(1, $job_description);
		$query->bindValue(2, $job_id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function remove_job($job_id){

		$query = $this->db->prepare("DELETE j, a FROM jobs j JOIN applications a ON j.job_id = a.job_id WHERE j.job_id =?");

		$query->bindValue(1, $job_id);

		$query2 = $this->db->prepare("DELETE FROM jobs WHERE job_id =?");

		$query2->bindValue(1, $job_id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}	

		try{
			$query2->execute();
		}catch(PDOException $e2){
			die($e2->getMessage());
		}	
	}

	public function jobdata($id) {

		$query = $this->db->prepare("SELECT * FROM `jobs` WHERE `job_id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}

	public function jobs_fetch_info($what, $field, $value){

		$allowed = array('job_id', 'job_title', 'job_description'); // I have only added few, but you can add more. However do not add 'password' eventhough the parameters will only be given by you and not the user, in our system.
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
		    throw new InvalidArgumentException;
		}else{
		
			$query = $this->db->prepare("SELECT $what FROM `jobs` WHERE $field = ?");

			$query->bindValue(1, $value);

			try{

				$query->execute();
				
			} catch(PDOException $e){

				die($e->getMessage());
			}

			return $query->fetchColumn();
		}
	}

	public function job_exists($id) {

		$query = $this->db->prepare("SELECT COUNT(`job_id`) FROM `jobs` WHERE `job_id`= ?");
		$query->bindValue(1, $id);
	
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

	public function get_jobs($id) {

		$query = $this->db->prepare("SELECT * FROM `jobs` WHERE `company_id`= ? ORDER BY `job_title` DESC");
		$query->bindValue(1, $id);

		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function list_jobs() {

		$query = $this->db->prepare("SELECT * FROM jobs j join company c on j.company_id = c.company_id ORDER BY `job_title` DESC");

		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function get_job_description($id) {

		$query = $this->db->prepare("SELECT `job_description` FROM `jobs` WHERE `job_id`= ? ORDER BY `job_title` DESC");
		$query->bindValue(1, $id);

		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function company_job_data($id) {

		$query = $this->db->prepare("SELECT * FROM jobs j JOIN company c on c.company_id = j.company_id WHERE j.job_id = ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}

}
