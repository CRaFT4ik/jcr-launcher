<?php

	define ('IMPASS_CHECK', true);
	include ("../jcr_connect.php");
	include ("../jcr_settings.php");
	
	$user		= sql_param($_GET['username']);
	$serverid	= sql_param($_GET['serverId']);
	
	$result		= $db -> query("SELECT $db_colUser FROM $db_table WHERE $db_colUser='$user' AND $db_colServer='$serverid'") or die ("Error");
	$row		= $result -> fetch_assoc();
	$realUser	= $row[$db_colUser];
	if ($user != $realUser) die(json_error("Bad login"));
	
	if ($result -> num_rows == 1)
	{
		$time = time();
		$id = md5($sessionKey.$user);
		
		$skin_url	= get_json_texture_url("skin");
		$cape_url	= get_json_texture_url("cloak");
		$elytra_url	= get_json_texture_url("elytra");
		
		$base64 = '{ "timestamp": "'.$time.'", "profileId": "'.$id.'", "profileName": "'.$realUser.'", "textures": { '.$skin_url.', '.$cape_url.', '.$elytra_url.' } }';
		echo '{"id": "'.$id.'", "name": "'.$realUser.'", "properties": [{"name": "textures", "value": "'.base64_encode($base64).'", "signature": "nope"}]}';
	} else
	{
		die (json_error("Bad login"));
	}
	
	
	
	function json_error($text)
	{
		return json_encode(array('error' => $text, 'errorMessage' => $text));
	}
	
	function get_json_texture_url($type)
	{
		global $realUser, $lowerSkinsCase, $skins_url, $cloaks_url;
		
		if ($type == "skin")
		{
			$login = $lowerSkinsCase ? strtolower($realUser) : $realUser;
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
			$login = $lowerSkinsCase ? strtolower($realUser) : $realUser;
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
		} else if ($type == "elytra")
		{
			$login = $lowerSkinsCase ? strtolower($realUser) : $realUser;
			if ($cloaks_url != null)
			{
				$url = $cloaks_url."/el_".$login.".png";
				$Headers = @get_headers($url);
				if (preg_match("|200|", $Headers[0]))
					return '"ELYTRA": { "url": "'.$url.'" }';
				else
					return '"ELYTRA": { "url": "'.$cloaks_url.'/el_default.png'.'" }';
			}
			
			if (file_exists("../files/elytra/el_".$login.".png")) return '"ELYTRA": { "url": "'.'http://'.$_SERVER["SERVER_NAME"].dirname(dirname($_SERVER["SCRIPT_NAME"])).'/files/elytra/el_'.$login.'.png'.'" }';
			else return '"ELYTRA": { "url": "'.'http://'.$_SERVER["SERVER_NAME"].dirname(dirname($_SERVER["SCRIPT_NAME"])).'/files/elytra/el_default.png" }';
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