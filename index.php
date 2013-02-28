<?
	do {
		$randomId = mt_rand(1, 8);
	} while ($randomId == $_REQUEST["p"]);
	if((int)$_REQUEST["p"]) {
		$problemId = (int)$_REQUEST["p"];
		$f = fopen("problems.txt", "r");
		$contents = fread($f, filesize("problems.txt"));
		$problems = preg_split("/\n/", $contents);
		
		if(count($problems) > $problemId and $problemId >= 1) {
			$problem = preg_split("/\t/", $problems[$problemId]);
			$compoundName = $problem[0];
			$correctRelationship = $problem[1];
			$incorrectFeedback = $problem[2];
			$correctFeedback = $problem[3];
		} else {
			$intro = true;
		}
	} else {
		$intro = true;
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Coursera | Stereotopic Relationships</title>
	<script type="text/javascript" src="http://www.metallacycle.com/play/coursera/lib/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.metallacycle.com/play/coursera/lib/jsmol/JSmol.min.js"></script>
	<script type="text/javascript" src="http://www.metallacycle.com/play/coursera/lib/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://www.metallacycle.com/play/coursera/lib/bootstrap/css/bootstrap.min.css" />
	
	<style type="text/css">
		.container {
			padding-bottom: 20px;
		}
		
		footer {
			border-top: 1px solid #EEE;
			padding: 10px 0 10px 10px; }
	</style>
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>Stereotopicity Trainer<br>
			<small>practice identifying stereotopic relationships</small></h1>
		</div>
		
		<div>
			<?
				if($intro) {
					echo '<p>Each problem on this page includes a molecule with two groups or atoms highlighted. Your task is to identify the stereotopic relationship shared by the groups, using either the <a target="_blank" href="http://www.youtube.com/watch?v=WIVJPBBUGsE">Q-test</a> or <a target="_blank" href="http://www.youtube.com/watch?v=facIqMwAFec">symmetry elements</a>. Examine the two- and three-dimensional structures provided, then select a relationship. Immediate feedback will be provided, and you can attempt each problem as many times as you\'d like. Click the button below to begin practicing.</p><p>There are <b>8</b> problems currently available in the Stereotopicity Trainer. Want to <a href="submit.html">submit your own problems?</a></p>';
					echo '<a class="btn btn-large btn-primary" href=".?p='.$randomId.'">Start Practicing!</a>';
					die('</div></div><footer><small>Created by <a href="http://www.metallacycle.com/">Michael Evans</a> in 2013.</small></footer>');
				}
			?>
			<? echo '<div class="btn-group"><a class="btn btn-small btn-primary" href=".">Home</a><a class="btn btn-small btn-primary" href=".?p='.$randomId.'">Next Problem</a></div>'; ?>
			<h2><? echo $compoundName; ?></h2>
			<p>
				<div class="q-prompt">
					What is the stereotopic relationship between the highlighted atoms/groups in the molecule shown? Consider the most symmetric conformer(s) of the molecule. Select a relationship below.
				</div>
				<div data-toggle="buttons-radio" class="mc-options btn-group">
					<button class="btn" id="homotopic" onclick="evaluate_response($(this).attr('id'));">Homotopic</button>
					<button class="btn" id="enantiotopic" onclick="evaluate_response($(this).attr('id'));">Enantiotopic</button>
					<button class="btn" id="diastereotopic" onclick="evaluate_response($(this).attr('id'));">Diastereotopic</button>
					<button class="btn" id="constitutionally-heterotopic" onclick="evaluate_response($(this).attr('id'));">Constitutionally Heterotopic</button>
				</div>
			</p>
			<div class="mol-image pull-right">
				<img src="http://www.metallacycle.com/play/coursera/assets/images/stereo/<? echo $problemId; ?>.png" alt="A Lewis structure of 4-tert-butylcyclohexanone. One hydrogen on each alpha position is highlighted orange." />
			</div>
			<div class="jsmol well" style="width:460px;">
				<script type="text/javascript">
					var jmol = 'jmol';
					var jmolOptions = {
						width: 460,
						height: 400,
						script: 'set background [242,242,242]; load http://www.metallacycle.com/play/coursera/assets/images/stereo/<? echo $problemId; ?>.jmol',
						jarPath: 'http://www.metallacycle.com/play/coursera/lib/jsmol/java',
						jarFile: 'JmolAppletSigned.jar',
						isSigned: true,
						j2sPath: 'http://www.metallacycle.com/play/coursera/lib/jsmol/j2s',
						use: 'HTML5',
						console: 'console-messages' };
					jmol = Jmol.getApplet(jmol, jmolOptions);
				</script>
			</div>
		</div>
	</div>
	<footer><small>Created by <a href="http://www.metallacycle.com/">Michael Evans</a> in 2013.</small></footer>
	
	<script type="text/javascript">
		var attempt = 1;
		function evaluate_response(res) {
			if(res == '<? echo $correctRelationship; ?>') {
				$('#' + res).addClass('btn-success').append('&nbsp;<b>' + attempt + '</b>');
				$('.mc-options').children().addClass('disabled');
				correct = '<div id="correct-fb" class="modal hide fade"><div class="modal-header"><h3>Correct!<a class="close pull-right" data-dismiss="modal">&times;</a></h3></div><div class="modal-body"><? echo $correctFeedback; ?></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Close</button></div></div>';
				$('body').append(correct);
				$('#correct-fb').modal('show');
			} else {
				$('#' + res).addClass('btn-danger').append('&nbsp;<b>' + attempt + '</b>');
				wrong = '<div id="wrong-fb" class="modal hide fade"><div class="modal-header"><h3>Incorrect!<a class="close pull-right" data-dismiss="modal">&times;</a></h3></div><div class="modal-body"><? echo $incorrectFeedback; ?></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Close</button></div></div>';
				$('body').append(wrong);
				$('#wrong-fb').modal('show');
				attempt++;
			}
		}
	</script>
	
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-24492949-2']);
		_gaq.push(['_trackPageview']);
		
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</body>
</html>