<?php

require_once 'class/AASkillsCalculator.php';

$AASkillsCalculator = new AASkillsCalculator();
?>

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="tmp/tmp_style.css">
	<link rel="stylesheet" type="text/css" href="css/style_aaSkillsCalculator.css">
	<script type="text/javascript" src="js/aa_skillsCalculator.js"></script>
	<title>Archeage Skills Calculator</title>
</head>

<body>
	<div id="container">
		<div id="logo">
			<img src="tmp/archeage_logo.png" />
		</div>
		<div id="skillCalculator">
			<?php echo $AASkillsCalculator->getTree(); ?>
		</div>
	</div>
</body>

</html>