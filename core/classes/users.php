<?php 
class Users{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}	
	
	public function update_user($first_name, $last_name, $city, $state, $bio, $skills, $image_location, $resume_location, $linked_in_profile, $id){

		$query = $this->db->prepare("UPDATE `users` SET
								`first_name`	= ?,
								`last_name`		= ?,
								`city`			= ?,
								`state`			= ?,
								`bio`			= ?,
								`skills`		= ?,
								`image_location`= ?,
								`resume_location`= ?,
								`linked_in_profile` = ?
								
								WHERE `user_id`  = ? 
								");

		$query->bindValue(1, $first_name);
		$query->bindValue(2, $last_name);
		$query->bindValue(3, $city);
		$query->bindValue(4, $state);
		$query->bindValue(5, $bio);
		$query->bindValue(6, $skills);
		$query->bindValue(7, $image_location);
		$query->bindValue(8, $resume_location);
		$query->bindValue(9, $linked_in_profile);
		$query->bindValue(10, $id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function change_password($user_id, $password) {

		global $bcrypt;

		/* Two create a Hash you do */
		$password_hash = $bcrypt->genHash($password);

		$query = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `user_id` = ?");

		$query->bindValue(1, $password_hash);
		$query->bindValue(2, $user_id);				

		try{
			$query->execute();
			return true;
		} catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public function recover($email, $generated_string) {

		if($generated_string == 0){
			return false;
		}else{
	
			$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `generated_string` = ?");

			$query->bindValue(1, $email);
			$query->bindValue(2, $generated_string);

			try{

				$query->execute();
				$rows = $query->fetchColumn();

				if($rows == 1){
					
					global $bcrypt;

					$username = $this->fetch_info('username', 'email', $email); // getting username for the use in the email.
					$user_id  = $this->fetch_info('user_id', 'email', $email);// We want to keep things standard and use the user's id for most of the operations. Therefore, we use id instead of email.
			
					$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$generated_password = substr(str_shuffle($charset),0, 10);

					$this->change_password($user_id, $generated_password);

					$query = $this->db->prepare("UPDATE `users` SET `generated_string` = 0 WHERE `user_id` = ?");

					$query->bindValue(1, $user_id);
	
					$query->execute();

					// mail($email, 'Your password', "Hello " . $username . ",\n\nYour your new password is: " . $generated_password . "\n\nPlease change your password once you have logged in using this password.\n\n-Screenlined team", "-fcarter@screenlined.com");
					$to      = $email;
					$subject = 'Your Password';
					$message = "Hello " . $username. ",\n\nYour your new password is: " . $generated_password . "\n\nPlease change your password once you have logged in using this password.\n\n-Screenlined Team";
					$headers = 'From: carter@screenlined.com' . "\r\n" .
   					'Reply-To: carter@screenlined.com' . "\r\n" .
   					'X-Mailer: PHP/' . phpversion();
					mail($to, $subject, $message, $headers);
				}else{
					return false;
				}

			} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

    public function fetch_info($what, $field, $value){

		$allowed = array('user_id', 'username', 'first_name', 'last_name', 'gender', 'bio', 'email'); // I have only added few, but you can add more. However do not add 'password' eventhough the parameters will only be given by you and not the user, in our system.
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
		    throw new InvalidArgumentException;
		}else{
		
			$query = $this->db->prepare("SELECT $what FROM `users` WHERE $field = ?");

			$query->bindValue(1, $value);

			try{

				$query->execute();
				
			} catch(PDOException $e){

				die($e->getMessage());
			}

			return $query->fetchColumn();
		}
	}

	public function confirm_recover($email){

		$username = $this->fetch_info('username', 'email', $email);// We want the 'id' WHERE 'email' = user's email ($email)

		$unique = uniqid('',true);
		$random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10);
		
		$generated_string = $unique . $random; // a random and unique string

		$query = $this->db->prepare("UPDATE `users` SET `generated_string` = ? WHERE `email` = ?");

		$query->bindValue(1, $generated_string);
		$query->bindValue(2, $email);

		try{
			
			$query->execute();

			// mail($email, 'Recover Password', "Hello " . $username. ",\r\nPlease click the link below:\r\n\r\nhttp://www.screenlined.com/recover.php?email=" . $email . "&generated_string=" . $generated_string . "\r\n\r\n We will generate a new password for you and send it back to your email.\r\n\r\n-- Screenlined");			
			$to = $email;
			$subject = 'Recover Password';
			$message = "Hello " . $username. ",\r\nPlease click the link below:\r\n\r\nhttp://www.screenlined.com/recover.php?email=" . $email . "&generated_string=" . $generated_string . "\r\n\r\n We will generate a new password for you and send it back to your email.\r\n\r\n-- Screenlined Team";
			$headers = 'From: carter@screenlined.com' . "\r\n" .
   			'Reply-To: carter@screenlined.com' . "\r\n" .
   			'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function user_exists($username) {
	
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `username`= ?");
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

	public function user_profile_exists($user_id) {
	
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id`= ?");
		$query->bindValue(1, $user_id);
	
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
	 
	public function email_exists($email) {

		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email`= ?");
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

	public function register($first_name, $last_name, $password, $email, $username){

		global $bcrypt; // making the $bcrypt variable global so we can use here

		$time 		= time();
		$ip 		= $_SERVER['REMOTE_ADDR']; // getting the users IP address
		$email_code = $email_code = uniqid('code_',true); // Creating a unique string.
		
		$password   = $bcrypt->genHash($password);

		$query 	= $this->db->prepare("INSERT INTO `users` (`first_name`, `last_name`, `password`, `email`, `ip`, `time`, `email_code`, `username`) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");

		$query->bindValue(1, $first_name);
		$query->bindValue(2, $last_name);
		$query->bindValue(3, $password);
		$query->bindValue(4, $email);
		$query->bindValue(5, $ip);
		$query->bindValue(6, $time);
		$query->bindValue(7, $email_code);
		$query->bindValue(8, $username);

		try{
			$query->execute();

			// mail($email, 'Please activate your account', "Hello " . $first_name. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.screenlined.com/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Screenlined");
			$to      = $email;
			$subject = 'Please activate your account';
			$message = "Hello " . $first_name. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.screenlined.com/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Screenlined Team";
			$headers = 'From: carter@screenlined.com' . "\r\n" .
   			'Reply-To: carter@screenlined.com' . "\r\n" .
   			'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function activate($email, $email_code) {
		
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");

		$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);

		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				
				$query_2 = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");

				$query_2->bindValue(1, 1);
				$query_2->bindValue(2, $email);				

				$query_2->execute();
				return true;

			}else{
				return false;
			}

		} catch(PDOException $e){
			die($e->getMessage());
		}

	}


	public function email_confirmed($email) {

		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email`= ? AND `confirmed` = ?");
		$query->bindValue(1, $email);
		$query->bindValue(2, 1);
		
		try{
			
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public function login($email, $password) {

		global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called

		$query = $this->db->prepare("SELECT `password`, `user_id` FROM `users` WHERE `email` = ?");
		$query->bindValue(1, $email);

		try{
			
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password']; // stored hashed password
			$id   				= $data['user_id']; // id of the user to be returned if the password is verified, below.
			
			if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
				return $id;	// returning the user's id.
			}else{
				return false;	
			}

		}catch(PDOException $e){
			die($e->getMessage());
		}
	
	}

	public function userdata($id) {

		$query = $this->db->prepare("SELECT * FROM `users` WHERE `user_id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}
	  	  	 
	public function get_users() {

		$query = $this->db->prepare("SELECT * FROM `users` ORDER BY `time` DESC");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function video_cover_letter($location, $username) {

		$query 	= $this->db->prepare("UPDATE `users` SET `video_cover_letter_location` = ? WHERE `username` = ?");

		$query->bindValue(1, $location);
		$query->bindValue(2, $username);	

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function statesList() {
		$states = array('AL'=>"Alabama",
					'AK'=>"Alaska",
					'AZ'=>"Arizona",
					'AR'=>"Arkansas",
					'CA'=>"California",
					'CO'=>"Colorado",
					'CT'=>"Connecticut",
					'DE'=>"Delaware",
					'DC'=>"District Of Columbia",
					'FL'=>"Florida",
					'GA'=>"Georgia",
					'HI'=>"Hawaii",
					'ID'=>"Idaho",
					'IL'=>"Illinois",
					'IN'=>"Indiana",
					'IA'=>"Iowa",
					'KS'=>"Kansas",
					'KY'=>"Kentucky",
					'LA'=>"Louisiana",
					'ME'=>"Maine",
					'MD'=>"Maryland",
					'MA'=>"Massachusetts",
					'MI'=>"Michigan",
					'MN'=>"Minnesota",
					'MS'=>"Mississippi",
					'MO'=>"Missouri",
					'MT'=>"Montana",
					'NE'=>"Nebraska",
					'NV'=>"Nevada",
					'NH'=>"New Hampshire",
					'NJ'=>"New Jersey",
					'NM'=>"New Mexico",
					'NY'=>"New York",
					'NC'=>"North Carolina",
					'ND'=>"North Dakota",
					'OH'=>"Ohio",
					'OK'=>"Oklahoma",
					'OR'=>"Oregon",
					'PA'=>"Pennsylvania",
					'RI'=>"Rhode Island",
					'SC'=>"South Carolina",
					'SD'=>"South Dakota",
					'TN'=>"Tennessee",
					'TX'=>"Texas",
					'UT'=>"Utah",
					'VT'=>"Vermont",
					'VA'=>"Virginia",
					'WA'=>"Washington",
					'WV'=>"West Virginia",
					'WI'=>"Wisconsin",
					'WY'=>"Wyoming");
		return $states;
	}

}