<!DOCTYPE html>
<html>
<head>
	<title>Poetic Meter Analysis</title>
	<meta charset="utf-8">
	<meta name="description" content="A utility to analyze the syllables of words for meter, specifically poetic meter." />
	<meta name="keywords" content="poetry,meter,utility,poems,syllable">
	<meta name="author" content="mxdrm">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="wordstress.js"></script>
	<link rel="stylesheet" type="text/css" href="reset.css">
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=PT+Mono|Arimo'>
	<link rel="stylesheet" type="text/css" href="stress.css">
</head>
<body>
	<div id="darken"></div>
	<header>
		<h1>Poetic/Syllable Meter Analysis</h1>
	</header>
	<div id="entry">
		<h2>Entry</h2>
			<p>Enter words below and press submit for a Poetic/Syllable <a href="https://en.wikipedia.org/wiki/Metre_(poetry)">meter</a> analysis. Only English for now. Spelling matters. Capitalization does not.</p>
			<form id="form_poem">
				<fieldset>
					<textarea id="form_poem_input" name="form_poem_input" placeholder="Enter Words Here" rows="25" maxlength="1000" required></textarea>
					<div id="charcountdiv"><p><span id="charCount">0</span> Characters. 1000 limit.</p></div>
					<input id="form_poem_submit" value="Submit" type="submit" class="btn" />
				</fieldset>
			</form>
			<p><span id="poem_working_notification"></span></p>
	</div>
	<div id="result">
		<h2>Legend <span id="legendhide">(-)</span></h2>
			<ul id="stress_legend">
				<li>Z: No Data.</li>
				<li>N: No stress(&#728;).</li>
				<li>M: Medium Stress(&#175;).</li>
				<li>H: Heavy Stress(&#175;).</li>
				<li>(#): Syllable count.</li>
			</ul>
		<h2>Results</h2>
		<div id="analysis_div">
			<p><span id="poem_test_result">None Yet.</span></p>
		</div>
		<div id="resultscontroller">
		<p>
			<button class="btn" id="resizer">Enlarge</button>
		</p>
			<form id="foothighlighter" action="">
				<label>Meter Division</label>
				<input type="radio" name="stress" id="stress_zero" value"0">0
				<input type="radio" name="stress" id="stress_two" value"2">2
				<input type="radio" name="stress" id="stress_three" value"3">3
			</form>
		</div>
	</div>
	<footer>
		<p>By <a href="http://www.mxdrm.com">mxdrm</a>. <a href="mailto:stress@mxdrm.com">email</a>. <a href="http://danlowlite.blogspot.com/2016/04/poem-meter-analysis.html">Why?</a> Data <span class="hidesmall"> modified </span> from <a href="http://www.speech.cs.cmu.edu/cgi-bin/cmudict">CMUDict 0.7</a>.</p>
	</footer>
</body>
</html>