<?
	$problemId = -1;
	$compoundName = "4-<i>tert</i>-butylcyclohexanone";
	if((int)$_REQUEST["p"]) {
		$problemId = (int)$_REQUEST["p"];
		$f = fopen("problems.txt", "r");
		$contents = fread($f, filesize("problems.txt"));
		$problems = preg_split("/\n/", $contents);
		$problem = preg_split("/\t/", $problems[$problemId]);
		$compoundName = $problem[0];
		$correctRelationship = $problem[1];
		$incorrectFeedback = $problem[2];
		$correctFeedback = $problem[3];
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Coursera | Stereotopic Relationships</title>
	<script type="text/javascript" src="http://www.metallacycle.com/play/coursera/lib/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.metallacycle.com/play/coursera/lib/jsmol/JSmol.min.js"></script>
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
			<h1>Practice Identifying Stereotopic Relationships<br>
			<small>template page</small></h1>
			
			<div class="span11">
				<h2><? echo $compoundName; ?></h2>
				<p>
					<div class="q-prompt">
						What is the stereotopic relationship between the highlighted atoms/groups in the molecule shown? Select a relationship below.
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
	</div>
	<footer><small>Created by <a href="http://www.metallacycle.com/">Michael Evans</a> in 2013.</small></footer>
	<script type="text/javascript" src="http://www.metallacycle.com/play/coursera/lib/bootstrap/js/bootstrap.min.js"></script>
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
</body>
</html>