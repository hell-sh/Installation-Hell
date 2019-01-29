<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Installation Hell</title>
	<meta name="title" content="Installation Hell">
	<meta name="description" content="Making the installation of things just a bit easier.">
	<meta name="copyright" content="Copyright (c) 2017-19 Hell.sh">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="Installation Hell">
	<meta name="twitter:author" content="@helldotsh">
	<meta name="twitter:description" content="Making the installation of things just a bit easier.">
	<meta property="og:site_name" content="Installation Hell">
	<meta property="og:title" content="Installation Hell">
	<meta property="og:description" content="Making the installation of things just a bit easier.">
	<meta property="og:type" content="website">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" crossorigin="anonymous">
	<style>.container{padding:60px 15px}.no-list-style li{list-style:none}</style>
</head>
<body>
	<div class="container">
		<h1>Welcome to Installation Hell</h1>
		<hr>
		<div class="jumbotron">
			<h2>One Command Installation</h2>
			<p><input id="wget-cmd" class="form-control" readonly onfocus="this.select()"></p>
			<p><input id="curl-cmd" class="form-control" readonly onfocus="this.select()"></p>
		</div>
		<p>Don't have any time to waste? <a href="templates">Here are some templates</a> to get your installations done now.</p>
		<?php
		$categories = json_decode(file_get_contents(__DIR__."/packages.json"), true);
		foreach($categories as $category)
		{
			?>
			<br>
			<h2><?=$category["name"];?></h2>
			<?php
			generatePackageList($category["packages"]);
		}
		function generatePackageList($packages,$parent=false)
		{
			?>
			<ul class="no-list-style">
				<?php
				foreach($packages as $package)
				{
					?>
					<li>
						<input id="<?=$package["id"];?>" type="checkbox"
						<?=($parent?" data-parent=\"".$parent."\"":"");?>
						<?=(isset($package["requirement"])?" data-requirement=\"".$package["requirement"]."\"":"");?>
						> <label for="<?=$package["id"];?>"><?=(isset($package["input"])?$package["input"]:$package["name"]);?></label><?
						if(isset($package["input"]))
						{
							?>
							<input type="text" id="input-<?=$package["id"];?>" class="form-control" style="min-width:200px;width:calc(100% - 256px);display:inline">
							<?
						}
						if(isset($package["children"]))
						{
							generatePackageList($package["children"],$package["id"]);
						}
						?>
					</li>
					<?
				}
				?>
			</ul>
			<?php
		}
		?>
		<p>Copyright (c) 2017-19 <a href="https://hell.sh/" target="_blank">Hell.sh</a> &middot; <a href="https://hell.sh/privacy" target="_blank">Privacy Policy</a> &middot; Installation Hell is <a href="https://github.com/hell-sh/Installation-Hell" target="_blank">open-source</a>.</p>
		<script src="https://cdn.hell.sh/jquery/latest/core.js" crossorigin="anonymous"></script>
		<script src="index.js"></script>
	</div>
</body>
</html>
