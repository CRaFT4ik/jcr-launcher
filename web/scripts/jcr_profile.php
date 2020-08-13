<?php

	define ('IMPASS_CHECK', true);
	include ("../jcr_connect.php");
	include ("../jcr_settings.php");
	
	$UUID = sql_param($_GET['uuid']);
	
	if ($UUID == null) die ("BadParams");
	
	$query = $db -> query("SELECT $db_colUser FROM $db_table WHERE $db_colUUID='$UUID'") or die($db -> error);
	$row = $query -> fetch_assoc();
	$getLogin = $row[$db_colUser];
	
	if ($getLogin == null) exit;
	
	$time = time();
	$skin_url = get_json_texture_url("skin");
	$cape_url = get_json_texture_url("cloak");
	
	$base64 = '{ "timestamp": "'.$time.'", "profileId": "'.$UUID.'", "profileName": "'.$getLogin.'", "textures": { '.$skin_url.', '.$cape_url.' } }';
	
	echo '{ "id": "'.$UUID.'", "name": "'.$getLogin.'", "properties": [ { "name": "textures", "value": "'.base64_encode($base64).'" } ] }';
	
	
	
	function get_json_texture_url($type)
	{
		global $getLogin, $lowerSkinsCase, $skins_url, $cloaks_url;
		
		if ($type == "skin")
		{
			$login = $lowerSkinsCase ? strtolower($getLogin) : $getLogin;
			if ($skins_url != null)
			{
				$url = $skins_url."/".$login.".png";
				$Headers = @get_headers($url);
				if (preg_match("|200|", $Headers[0]))
					return '"SKIN": { "url": "'.$url.'" }';
				else
					return '"SKIN": { "url": "'.$skins_url.'/default.png'.'" }';
			}
			
			if (file_exists("../files/skins/".$login.".png")) return '"SKIN": { "url": "'.'http://'.$_SERVER["SERVER_NAME"].dirname(dirname($_SERVER["SCRIPT_NAME"])).'/files/skins/'.$login.'.png'.'" }';
			else return '"SKIN": { "url": "'.'http://'.$_SERVER["SERVER_NAME"].dirname(dirname($_SERVER["SCRIPT_NAME"])).'/files/skins/default.png" }';
		} else if ($type == "cloak")
		{
			$login = $lowerSkinsCase ? strtolower($getLogin) : $getLogin;
			if ($cloaks_url != null)
			{
				$url = $cloaks_url."/cl_".$login.".png";
				$Headers = @get_headers($url);
				if (preg_match("|200|", $Headers[0]))
					return '"CAPE": { "url": "'.$url.'" }';
				else
					return '"CAPE": { "url": "'.$cloaks_url.'/cl_default.png'.'" }';
			}
			
			if (file_exists("../files/cloaks/cl_".$login.".png")) return '"CAPE": { "url": "'.'http://'.$_SERVER["SERVER_NAME"].dirname(dirname($_SERVER["SCRIPT_NAME"])).'/files/cloaks/cl_'.$login.'.png'.'" }';
			else return '"CAPE": { "url": "'.'http://'.$_SERVER["SERVER_NAME"].dirname(dirname($_SERVER["SCRIPT_NAME"])).'/files/cloaks/cl_default.png" }';
		}
	}
	
	function sql_param($string)
	{
		global $db;
		(string) $string = $string;
		$string = PREG_REPLACE("/[^\w- ]|INSERT|DELETE|UPDATE|UNION|SET|SELECT|TRUNCATE|DROP|TABLE/i", "", $string);
		$string = TRIM($string);
		$db -> real_escape_string($string);
		return $string;
	}
	
?>