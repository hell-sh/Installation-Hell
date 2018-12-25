<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Installation Hell</title>
	<meta name="title" content="Installation Hell">
	<meta name="description" content="Making the installation of things just a bit easier.">
	<meta name="copyright" content="Copyright (c) 2017-2018, Hellsh">
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
		<p>Copyright (c) 2017-2018, Hellsh &middot; <a href="https://hellsh.com/privacy">Privacy Policy</a> &middot; Installation Hell is <a href="https://github.com/hell-sh/Installation-Hell" target="_blank">open-source</a>.</p>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
		<script>
			var packages=[];
			document.addEventListener("DOMContentLoaded",function()
			{
				var hash=location.hash.toString().replace("#","");
				if(hash=="")
				{
					$(":checked").each(function()
					{
						addPackage(this.id);
					});
				}
				else
				{
					var packages_=hash.split(",");
					$(":checked").prop("checked",false);
					$(packages_).each(function()
					{
						var arr=this.split(":"),
						package=arr[0];
						packages.push(package);
						$("#"+package).prop("checked",true);
						if(this.length>(package.length+1))
						{
							$("#input-"+package).val(decodeURIComponent(this.substr(package.length+1)));
						}
					});
				}
				updatePackages();
				$("[type='checkbox']").change(function()
				{
					if(this.checked)
					{
						addPackage(this.id);
						if($(this).attr("data-parent"))
						{
							var parent=$("#"+$(this).attr("data-parent"));
							if(!parent.is(":checked"))
							{
								parent.prop("checked",true).change();
							}
						}
						if($(this).attr("data-requirement"))
						{
							var requirement=$("#"+$(this).attr("data-requirement"));
							if(!requirement.is(":checked"))
							{
								requirement.prop("checked",true).change();
							}
						}
					}
					else
					{
						removePackage(this.id);
						$("[data-parent='"+this.id+"']:checked").prop("checked",false).change();
						$("[data-requirement='"+this.id+"']:checked").prop("checked",false).change();
					}
					packages.sort();
					updatePackages();
				});
				$("input[type='text']").on("input",updatePackages);
			});
			function addPackage(id)
			{
				if($.inArray(id, packages) == -1)
				{
					packages.push(id);
				}
			}
			function removePackage(id)
			{
				if($.inArray(id, packages) > -1)
				{
					packages.splice($.inArray(id, packages), 1);
				}
			}
			function updatePackages()
			{
				if(packages.length==0)
				{
					$("#wget-cmd").val("# Installus Nothingus");
					$("#curl-cmd").val("");
					history.pushState($("title").html(),{},"#");
				}
				else
				{
					var values = "", values_unset = "", hash = "", uri = "";
					$(packages).each(function()
					{
						uri += this;
						hash += this;
						if($("#input-"+this).length>0)
						{
							values += "export " + this.toUpperCase().split("-").join("_") + "=\"" + $("#input-"+this).val().split("\"").join("\\\"") + "\" && ";
							values_unset += " && unset " + this.toUpperCase().split("-").join("_");
							hash += ":" + encodeURIComponent($("#input-"+this).val());
						}
						uri += ",";
						hash += ",";
					});
					uri = uri.substr(0, uri.length - 1);
					hash = hash.substr(0, hash.length - 1);
					history.pushState($("title").html(),{},"#"+hash);
					$("#wget-cmd").val(values + "wget -qO- https://installation.hell.sh/"+uri+" | bash" + values_unset);
					$("#curl-cmd").val(values + "curl -sSL https://installation.hell.sh/"+uri+" | bash" + values_unset);
				}
			}
		</script>
	</div>
</body>
</html>
