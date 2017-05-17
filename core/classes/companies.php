<?php 
class Companies{

	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}		

	public function update_company($bio, $hq, $image_location, $linked_in_profile, $company_id){

		$query = $this->db->prepare("UPDATE `company` SET `company_bio` = ?, `company_hq` = ?, `logo_location`= ?, `company_linked_in_profile`= ? WHERE `company_id` = ?");

		$query->bindValue(1, $bio);
		$query->bindValue(2, $hq);
		$query->bindValue(3, $image_location);
		$query->bindValue(4, $linked_in_profile);
		$query->bindValue(5, $company_id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function company_fetch_info($what, $field, $value){

		$allowed = array('company_id', 'company_username', 'company_name', 'company_bio', 'company_email'); // I have only added few, but you can add more. However do not add 'password' eventhough the parameters will only be given by you and not the user, in our system.
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
		    throw new InvalidArgumentException;
		}else{
		
			$query = $this->db->prepare("SELECT $what FROM `company` WHERE $field = ?");

			$query->bindValue(1, $value);

			try{

				$query->execute();
				
			} catch(PDOException $e){

				die($e->getMessage());
			}

			return $query->fetchColumn();
		}
	}


	public function company_email_exists($email) {

		$query = $this->db->prepare("SELECT COUNT(`company_id`) FROM `company` WHERE `company_email`= ?");
		$query->bindValue(1, $email);
	
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

	public function company_id_exists($company_id) {

		$query = $this->db->prepare("SELECT COUNT(`company_id`) FROM `company` WHERE `company_id`= ?");
		$query->bindValue(1, $company_id);
	
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

	public function company_exists($username) {
	
		$query = $this->db->prepare("SELECT COUNT(`company_id`) FROM `company` WHERE `company_username`= ?");
		$query->bindValue(1, $username);
	
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

	public function company_login($name, $username, $password) {

		global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called

		$query = $this->db->prepare("SELECT `company_password`, `company_id` FROM `company` WHERE `company_username` = ?");
		$query->bindValue(1, $username);

		try{
			
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['company_password']; // stored hashed password
			$id   				= $data['company_id']; // id of the user to be returned if the password is verified, below.
			
			if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
				return $id;	// returning the user's id.
			}else{
				return false;	
			}

		}catch(PDOException $e){
			die($e->getMessage());
		}
	
	}


	public function companydata($id) {

		$query = $this->db->prepare("SELECT * FROM `company` WHERE `company_id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}

	public function get_companies() {

		$query = $this->db->prepare("SELECT * FROM `company` ORDER BY `company_name` DESC");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function easy_invite($job_id, $company_id, $email, $company_name){

		$query = $this->db->prepare("INSERT INTO `invitations` (`job_id`, `company_id`, `email`, `company_name`) VALUES (?,?,?,?) ");

		$query->bindValue(1, $job_id);
		$query->bindValue(2, $company_id);
		$query->bindValue(3, $email);
		$query->bindValue(4, $company_name);

		try{
			$query->execute();

			$to      = $email;
			$subject = 'We Want You at '.$company_name;
			$message = "Hello,\r\nWe're very interested in you. Please consider applying. \r\n\r\n http://screenlined.com/job?job_id=".$job_id." \r\n\r\n--".$company_name;
			$headers = 'From: '.$company_name. "\r\n" .
   			'Reply-To: do-not-reply@'.$company_name.'.com' . "\r\n" .
   			'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function custom_invite($job_id, $company_id, $email, $company_name, $custom_message){

		$query = $this->db->prepare("INSERT INTO `invitations` (`job_id`, `company_id`, `email`, `company_name`, `message`) VALUES (?,?,?,?,?) ");

		$query->bindValue(1, $job_id);
		$query->bindValue(2, $company_id);
		$query->bindValue(3, $email);
		$query->bindValue(4, $company_name);
		$query->bindValue(5, $custom_message);

		try{
			$query->execute();

			$to      = $email;
			$subject = 'We Want You at '.$company_name;
			$message = $custom_message."\r\n\r\n http://screenlined.com/job?job_id=".$job_id;
			$headers = 'From: '.$company_name. "\r\n" .
   			'Reply-To: do-not-reply@'.$company_name.'.com' . "\r\n" .
   			'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function mass_invite($job_id, $company_id, $email, $company_name){

		$query = $this->db->prepare("INSERT INTO `invitations` (`job_id`, `company_id`, `email`, `company_name`) VALUES (?,?,?,?) ");

		$query->bindValue(1, $job_id);
		$query->bindValue(2, $company_id);
		$query->bindValue(3, $email);
		$query->bindValue(4, $company_name);

		try{
			$query->execute();

			// $to      = $email;
			$to = $_POST['email1'] . ', ';
			$to .= $_POST['email2'] . ', ';
			$to .= $_POST['email3'];
			$subject = 'We Want You at '.$company_name;
			$message = "Hello,\r\nWe're very interested in you. Please consider applying. \r\n\r\n http://screenlined.com/job?job_id=".$job_id." \r\n\r\n--".$company_name;
			$headers = 'From: '.$company_name. "\r\n" .
   			'Reply-To: do-not-reply@'.$company_name.'.com' . "\r\n" .
   			'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

}
