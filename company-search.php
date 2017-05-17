<?php
include 'core/connect/mysqli_connect.php';

/************************************************
	Search Functionality
************************************************/

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a href="urlString">';
$html .= '<span>companyNameString</span>';
$html .= '</a>';
$html .= '</li>';

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $dbc->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT company_name, company_username FROM company WHERE company_name LIKE "%'.$search_string.'%"';

	// Do Search
	$result = $dbc->query($query);
	while($results = $result->fetch_array()) {
		$result_array[] = $results;
	}

	// Check If We Have Results
	if (isset($result_array)) {
		foreach ($result_array as $result) {

			// Format Output Strings And Hightlight Matches
			$display_company_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['company_name']);
			$display_url = 'companies-profile?company='.urlencode($result['company_username']);

			// Company Name
			$output = str_replace('companyNameString', $display_company_name, $html);

			// Insert URL
			$output = str_replace('urlString', $display_url, $output);

			// Output
			echo($output);
		}
	}else{

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('companyNameString', '<b>No Results Found.</b>', $output);

		// Output
		echo($output);
	}
}

?>