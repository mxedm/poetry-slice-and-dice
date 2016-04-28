$(document).ready(function(){
	$('#form_poem_input').on('keyup', function (){ //This is a counter for the text area.
		var len = $(this).val().length;
		$('#charCount').text(len);
	});
	$('#resizer').click(function(){
		if ($('#darken').is(':visible')) {
			$('#darken').removeClass('large');
			$('#result').removeClass('large');
			$('#resizer').html('Enlarge');
		} else {
			$('#darken').addClass('large');
			$('#result').addClass('large');
			$('#resizer').html('Restore');
		}
	});
	$('#darken').click(function(){
		$('#darken').removeClass('large');
		$('#result').removeClass('large');
		$('#resizer').html('Enlarge');
	});
	$('#stress_zero').click(function(){
		$('.stress').removeClass('highlight');
	});
	$('#stress_two').click(function(){ //kind of brute force.
		$('.stress').removeClass('highlight');
		$('.2').addClass('highlight');
		$('.4').addClass('highlight');
		$('.6').addClass('highlight');
		$('.8').addClass('highlight');
		$('.10').addClass('highlight');
		$('.12').addClass('highlight');
		$('.14').addClass('highlight');
		$('.16').addClass('highlight');
		$('.18').addClass('highlight');
		$('.20').addClass('highlight');
	});
	$('#stress_three').click(function(){ //kind of brute force.
		$('.stress').removeClass('highlight');
		$('.3').addClass('highlight');
		$('.6').addClass('highlight');
		$('.9').addClass('highlight');
		$('.12').addClass('highlight');
		$('.15').addClass('highlight');
		$('.18').addClass('highlight');
		$('.21').addClass('highlight');
	});
	$('#legendhide').click(function(){ //hide the legend on click
		if ($("#stress_legend").is(":visible")) {
			$("#stress_legend").slideUp(function() {
				$('#legendhide').html("(+)");
			});
		} else {
			$("#stress_legend").slideDown(function() {
				$('#legendhide').html("(-)");
			});	
		}
	});
	$.valHooks.textarea = { //remove newline characters from textarea when submitting. 
		get: function(elem) {
			return elem.value.replace(/\r?\n/g, "\r\n");
		}
	};

	$('#form_poem_submit').click(function(){ //The multi-word function.
		event.preventDefault();	// Don't want to submit twice.

		// Set some variables.
		$result_span = $('#poem_test_result');
		$analysis_home = $('#analysis_div');
		$working_span = $('#poem_working_notification');
		$lookup_file = "lookup_poem.php";

		$working_span.html("Working!!!");	// Notify user that something is happening.

		//get data and pass it on.
		var $dataRaw = $("textarea[name='form_poem_input']").val();
		var $dataPass = $dataRaw.replace(/(\r\n|\n|\r)/gm," THISISABRK "); //this is hacky. I don't like it. 10 chars
		$.ajax({
			type: "POST",
			url: $lookup_file,
			dataType: "json",
			data: { value: $dataPass },
			success: function(data_json){ // We got data back. Time to do the magic thing. 				
				$analysis_home.empty(); //We don't need the thing as it is. 
			
				//poem in multiple table views. Each line is a string in an array. Kind of a horizontal view. 
				var recreate_poem_string_prefix = "";
				var recreate_poem_string_accumulator = "";
				var recreate_poem_string_words = "<table class='result_table_hor'><tbody><tr class='word'>";
				var recreate_poem_string_pattern = "<tr class='pattern'>";
				var stress_counter = "";
				var temp_pattern = "";
				var position = 0;
		
				$.each(data_json.records, function (i, object){
					if (object.word === "THISISABRK") {
						recreate_poem_string_accumulator += recreate_poem_string_words + "</tr>";
						if (stress_counter.length > 0) {
							recreate_poem_string_accumulator += recreate_poem_string_pattern + "<td class='counter'>(" + stress_counter.length + ")</td></tr></tbody></table>";
						} else {
							recreate_poem_string_accumulator += recreate_poem_string_pattern + "</tr></tbody></table>";
						}
						recreate_poem_string_words = "<table class='result_table_hor'><tbody><tr class='word'>";
						recreate_poem_string_pattern = "<tr class='pattern'>";
						stress_counter = "";
						temp_pattern = "";
						position = 0;
						return true; 
					}
					recreate_poem_string_words += "<td class='word'>" + object.word + "</td>";
			
					for (var i = 0, len = object.pattern.length; i < len; i++) {
						position++;
						temp_pattern += "<span class='stress " + position + "'>" + object.pattern[i] + "</span>"; //assigning each to its own span.
					}

					recreate_poem_string_pattern +="<td class='pattern'>" + temp_pattern + "</td>";
					temp_pattern = "";
					stress_counter += object.pattern; // just counting the actual letters here
				});
				recreate_poem_string_accumulator += recreate_poem_string_words + "</tr>";
				if (stress_counter.length > 0) {
					recreate_poem_string_accumulator += recreate_poem_string_pattern + "<td class='counter'>(" + stress_counter.length + ")</td></tr></tbody></table>";//end of table
				} else {
					recreate_poem_string_accumulator += recreate_poem_string_pattern + "<td class='counter'></td></tr></tbody></table>";//end of table
				}				
				$analysis_home.append(recreate_poem_string_accumulator); //display the string
				$('table tr').find('td:last').attr('colspan',999);
				$('#resultscontroller').fadeIn("fast", function(){

				});
			},
			error: function(xhr, status, errorThrown){
				$result_span.html = "Error. " + errorThrown + " Maybe try again?"
			}
		});
		$working_span.html(""); //Remove working notification.
	});  //End multi word lookup.

});