<?php
include 'core/connect/mysqli_connect.php';

/************************************************
	Search Functionality
************************************************/

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a href="urlString">';
$html .= '<span>jobTitleString - companyNameString</span>';
$html .= '</a>';
$html .= '</li>';

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $dbc->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT job_title, job_id, company_name FROM jobs j join company c on j.company_id = c.company_id WHERE job_title LIKE "%'.$search_string.'%"';

	// Do Search
	$result = $dbc->query($query);
	while($results = $result->fetch_array()) {
		$result_array[] = $results;
	}

	// Check If We Have Results
	if (isset($result_array)) {
		foreach ($result_array as $result) {

			// Format Output Strings And Hightlight Matches
			$display_job_title = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['job_title']);
			$display_company_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['company_name']);
			$display_url = 'job?job_id='.urlencode($result['job_id']);

			// Insert Name
			$output = str_replace('jobTitleString', $display_job_title, $html);

			// Insert Function
			$output = str_replace('companyNameString', $display_company_name, $output);

			// Insert URL
			$output = str_replace('urlString', $display_url, $output);

			// Output
			echo($output);
		}
	}else{

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('jobTitleString', '<b>No Results Found</b>', $output);
		$output = str_replace('companyNameString', 'Sorry', $output);

		// Output
		echo($output);
	}
}

?>