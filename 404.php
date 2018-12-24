<?php
http_response_code(200);
header("Content-Type: text/plain");
$chosen_packages = explode(",", substr($_SERVER["REQUEST_URI"], 1));
$chosen_packages_ = [];
foreach($chosen_packages as $package)
{
	if(trim($package) != "")
	{
		array_push($chosen_packages_, trim(urldecode($package)));
	}
}
sort($chosen_packages_);
if("/".join(",",$chosen_packages_)!=$_SERVER["REQUEST_URI"])
{
	http_response_code(401);
	header("Location: /".join(",",$chosen_packages_));
	exit;
}
?>
#!/bin/bash

if [ $(whoami) != "root" ]; then
	echo ""
	echo "This script needs to be run as root."
else
<?php
function installPackages($packages,$prefix="")
{
	global $chosen_packages;
	foreach($packages as $package)
	{
		if(in_array($package["id"], $chosen_packages) && (!isset($package["requirement"]) || in_array($package["requirement"], $chosen_packages)))
		{
?>	echo ""
	echo "<?=$prefix."> ".$package["name"];?>"
<?
			foreach($package["lines"] as $line)
			{
				echo "\t".$line."\n";
			}
		}
		if(isset($package["children"]))
		{
			installPackages($package["children"], $prefix."  ");
		}
	}
}
$categories = json_decode(file_get_contents("packages.json"), true);
foreach($categories as $category)
{
	installPackages($category["packages"]);
}
?>
	echo ""
	echo "Thank you for using Installation.Hell.sh."
fi
echo ""
