<?php 
session_start();
require 'connect/database.php';
require 'classes/users.php';
require 'classes/companies.php';
require 'classes/jobs.php';
require 'classes/comments.php';
require 'classes/applications.php';
require 'classes/general.php';
require 'classes/bcrypt.php';
 
$users 		= new Users($db);
$companies 	= new Companies($db);
$jobs 		= new Jobs($db);
$applications = new Applications($db);
$comments 	= new Comments($db);
$general 	= new General();
$bcrypt 	= new Bcrypt(12);
 
error_reporting(0);

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
 
if ($general->logged_in() === true)  {
	$user_id 	= $_SESSION['id'];
	$user 	= $users->userdata($user_id);

	$company_id 	= $_SESSION['id'];
	$company 	= $companies->companydata($company_id);

	$job_id 	= $_SESSION['id'];
	$job 	= $jobs->jobdata($job_id);

}

if ($general->company_logged_in() === true)  {
	$user_id 	= $_SESSION['company_id'];
	$user 	= $users->userdata($user_id);

	$company_id 	= $_SESSION['company_id'];
	$company 	= $companies->companydata($company_id);

	$job_id 	= $_SESSION['company_id'];
	$job 	= $jobs->jobdata($job_id);

}
 
$errors = array();
 
// ob_start(); 
?>