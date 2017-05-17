/* JS File */

// Start Ready
$(document).ready(function() {  


	// Icon Click Focus
	$('div.icon').click(function(){
		$('input#job-search').focus();
	});

	// Job Search
	// On Search Submit and Get Results
	function search() {
		var query_value = $('input#job-search').val();
		$('b#search-string').html(query_value);
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "job-search.php",
				data: { query: query_value },
				cache: false,
				success: function(html){
					$("ul#job-results").html(html);
				}
			});
		}return false;    
	}

	$("input#job-search").bind("keyup", function(e) {
		// Set Timeout
		clearTimeout($.data(this, 'timer'));

		// Set Search String
		var search_string = $(this).val();

		// Do Search
		if (search_string == '') {
			$("ul#job-results").fadeOut();
			$('h4#job-results-text').fadeOut();
		}else{
			$("ul#job-results").fadeIn();
			$('h4#job-results-text').fadeIn();
			$(this).data('timer', setTimeout(search, 100));
		};
	});

});