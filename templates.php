<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Installation Script Templates</title>
	<meta name="title" content="Installation Script Templates">
	<meta name="copyright" content="Copyright (c) 2017-2018, Hellsh">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="Installation Script Templates">
	<meta property="og:site_name" content="Installation Hell">
	<meta property="og:title" content="Installation Script Templates">
	<meta property="og:type" content="website">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" crossorigin="anonymous">
	<style>.container{padding:60px 15px}</style>
</head>
<body>
	<div class="container">
		<h1>Installation Script Templates</h1>
		<hr>
		<p>If you don't have the time to <a href=".#">manually define what is to be installed</a>, then feel free to use one of those templates:</p>
		<?php
		function templateList($templates)
		{
			?>
			<ul>
				<?php
				foreach($templates as $template)
				{
					?>
					<li><a href=".#<?=$template["packages"];?>" data-fixed><?=$template["name"];?></a>: <?=$template["desc"];?></li>
					<?php
				}
				?>
			</ul>
			<?php
		}
		templateList(json_decode(file_get_contents(__DIR__."/templates.json"), true));
		?>
		<p>Is there anything missing? This list of templates is <a href="https://github.com/hell-sh/Installation-Hell" target="_blank">on Github</a>.</p>
	</div>
</body>
</html>
