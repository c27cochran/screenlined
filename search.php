<?php
include 'core/connect/mysqli_connect.php';

/************************************************
	Search Functionality
************************************************/

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a href="urlString">';
$html .= '<span>firstNameString lastNameString</span>';
$html .= '<h6>cityString stateString</h6>';
$html .= '</a>';
$html .= '</li>';

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $dbc->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT * FROM users WHERE skills LIKE "%'.$search_string.'%" OR city LIKE "%'.$search_string.'%" OR first_name LIKE "%'.$search_string.'%"';

	// Do Search
	$result = $dbc->query($query);
	while($results = $result->fetch_array()) {
		$result_array[] = $results;
	}

	// Check If We Have Results
	if (isset($result_array)) {
		foreach ($result_array as $result) {

			// Format Output Strings And Hightlight Matches
			$display_first_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['first_name']);
			$display_last_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['last_name']);
			$display_city = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['city']);
			$display_state = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['state']);
			$display_url = 'applicant-profile?user_id='.urlencode($result['user_id']);

			$output = str_replace('firstNameString', $display_first_name, $html);
			$output = str_replace('lastNameString', $display_last_name, $output);
			$output = str_replace('cityString', $display_city, $output);
			$output = str_replace('stateString', $display_state, $output);

			// Insert URL
			$output = str_replace('urlString', $display_url, $output);

			// Output
			echo($output);
		}
	}else{

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('firstNameString', '<b>No Results Found.</b>', $output);
		$output = str_replace('lastNameString', 'Sorry', $output);
		$output = str_replace('cityString', '', $output);
		$output = str_replace('stateString', '', $output);

		// Output
		echo($output);
	}
}

?>