<?php
	session_start();
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	if (isset($_POST["value"])) {
		//typical DB info and variable declaration. 
		include_once "dbconnect.php"; //connection data and stuff.
		$mysqli = new mysqli($db_servername, $db_username, $db_password, $db_database);
		$outp = "";
//collect data, check for validity, sanitize, etc. The too many characters shouldn't even be a thing because the form shouldn't allow them to, but this will ensure that limit is upheld. 
		$unsafe_poem_to_query = $_POST["value"];
		$poem_to_query = $mysqli->real_escape_string($unsafe_poem_to_query);
		if (strlen($poem_to_query) > 1000) {
			exit("Too many characters (" . strlen($poem_to_query) . "). Try batching your requests.");
		}
//Let's get to work. 
		$re = "/[^a-zA-Z]|:|[\\s]/"; //regex anything that isn't a letter, basically. 
		$poem_explode_result = preg_split($re, $poem_to_query, -1, PREG_SPLIT_OFFSET_CAPTURE); //split the poem into an array 
//Okay, for each of the words, we'll assemble the JSON info so we can display it nicely later. 
		foreach ($poem_explode_result as $value) {
			if ($value['0'] == "") {continue;} // We're catching stuff that should be gotten by the regex? If it's an empty string we should just go to the next record. There's a better way to do this but damned if I can figure it out. I've never used regex before.
			if ($outp != "") {$outp .= ",";} //JSON format needs a comma unless it's the first record, of course. 
			$outp .= '{"word":"' . $value['0'] . '",';
			$outp .= '"place":"' . $value['1'] . '",';
			$word_to_find = strtoupper($value['0']);
			$SQL_word_query = "SELECT * FROM tbl_stresses WHERE word ='" . $word_to_find . "' LIMIT 1";
			$result = $mysqli->query($SQL_word_query);
			$row_count = $result->num_rows;
			if ($row_count == "0") {
				$output_pattern = "Z"; // We got nothing.
			} else {
				while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
					$output_pattern = (string)$rs["pattern"]; //This needs to be a string.
				}
			}
			$outp .= '"pattern":"'. $output_pattern . '"}'; 
		}
		
	} else {
		$outp = "{'error':'No Data Submitted'}";
	}
//output
	$outp ='{"records":['.$outp.']}';
//done
	echo($outp);
	$mysqli->close();
?>