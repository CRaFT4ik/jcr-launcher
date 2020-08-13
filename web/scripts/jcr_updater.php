<?php
	/*
	 * Скрипт будет возвращать ложные ссылки с одноразовым ключом:
	 * в файле .htaccess полный путь на обновление исходников, точнее перенаправление с ложной ссылки на полную,
	 * но только если одноразовый ключ, записанный в скрытый файл, совпадет.
	 * 
	 * Скрипт генерирует случайный код и заносит его в базу + время (т.е. во сколько он был сгенерирован)
	 * при обращении по этой же ссылке со сгенерированным кодом он проверяет сколько времени прошло с момента занесения
	 * кода в базу (for example 5 minutes). при том, если не прошло ещё 5 минут, редикт "без палева" перенаправит на файл для загрузки.
	 * 
	 */
	 
	 // RewriteRule view?photo=(\w+) /images/$1.jpg
	 // http://forum.php.su/topic.php?forum=75&topic=2634
	
	define("IMPASS_CHECK", true);
	
	include("../jcr_connect.php");
	
	$action		= $db -> real_escape_string($_GET['action']);
	$getLogin	= $db -> real_escape_string($_GET['login']);
	$getPass	= $db -> real_escape_string($_GET['password']);
	$request	= $db -> real_escape_string($_GET['request']);
	$getKey		= $db -> real_escape_string($_GET['code']);
	
	$updater_path		= "JCR_Launcher/updater/jcr_updater.jar";				// путь к файлу обновления JCR Updater
	$source_path		= "../updater/versions/jcr_source_v6.2.1.zip";			// путь к архиву обновления исходников
	$source_version		= "v6.2.1";												// последняя версия исходников
	$wait_time			= 300;													// время на активацию ссылки (в секундах)
	$wait_db			= 60;													// интервал на новый запрос к б.д. (в секундах)
	
	//$source_path_TRAP	= "../updater/versions/trap/6.0.3/";					// путь к архиву обновления исходников (план TRAP)
	
	if ($action == "update")
	{
		if ($getLogin != null && $getPass != null)
		{
			$query		= $db -> query("SELECT `id`, `login`, `password`, `temp_key`, `temp_date`, `source_version`, `downloads_number` FROM `jcr_updater` WHERE `login`='$getLogin'") or die($db -> error);
			$row		= $query -> fetch_assoc();
			$getLogin	= $row['login'];
			$realPass	= handle_md5(md5(md5($row['password'])));
			$temp_key	= $row['temp_key'];
			$date_time	= $row['temp_date'];
			$source_ver	= $row['source_version'];
			$user_id	= $row['id'];
			$downloads	= $row['downloads_number'];
			
			if ($getPass == $realPass)
			{
				$check_time = check_time($date_time);

				
				if ($request == "wload")
				{
					if ($check_time < $wait_db)
					{
						echo "Wait<:s:>".($wait_db - $check_time);
						
					} else if ($getKey == null)
					{
						$data = write_to_base($getLogin);
						echo "code=".$data."<:v:>".$source_ver."<:v:>".$source_version;
						
					} else echo "BadParams";
				} else if ($request == "download")
				{
					if ($getKey == md5($temp_key) && $check_time < $wait_time)
					{
						delete_from_base($getLogin);
						
						$path_to_file = $source_path; //$source_path_TRAP.choose_zip_name_by_Id($user_id); // TRAP
						
						/* Скачивание файла */
						$filename_for_client = "jcr_source_".generate_code().".zip";
						header("Cache-Control: private");
						header("Content-Type: application/force-download");
						header("Content-Length: ".filesize($path_to_file)); // $source_path
						header("Content-Disposition: filename=".$filename_for_client);
						$r = readfile($path_to_file); // $source_path
						
					} else echo "BadParams";
					
				} else echo "BadParams";
				
			} else echo "BadData";
			
		} else echo "BadParams";
	} else if ($action == "checkupdate")
	{
		echo md5_file("../../".$updater_path)."<::>".$updater_path;
	}
	
	/* *** FUNCTIONS *** */
	
	/*
	function choose_zip_name_by_Id($id)
	{
		switch ($id)
		{
            case 100: return "jcr_source_v6.0.3_100_6396244.zip";
            case 101: return "jcr_source_v6.0.3_101_3803244.zip";
            case 102: return "jcr_source_v6.0.3_102_8094852.zip";
            case 103: return "jcr_source_v6.0.3_103_4309875.zip";
            case 104: return "jcr_source_v6.0.3_104_5781643.zip";
            case 105: return "jcr_source_v6.0.3_105_8650313.zip";
            case 106: return "jcr_source_v6.0.3_106_1921857.zip";
            case 107: return "jcr_source_v6.0.3_107_8956435.zip";
            case 108: return "jcr_source_v6.0.3_108_2640770.zip";
            case 109: return "jcr_source_v6.0.3_109_9665794.zip";
            case 10: return "jcr_source_v6.0.3_10_3668179.zip";
            case 110: return "jcr_source_v6.0.3_110_6621701.zip";
            case 11: return "jcr_source_v6.0.3_11_9240991.zip";
            case 12: return "jcr_source_v6.0.3_12_7060506.zip";
            case 13: return "jcr_source_v6.0.3_13_4991724.zip";
            case 14: return "jcr_source_v6.0.3_14_3910343.zip";
            case 15: return "jcr_source_v6.0.3_15_8354264.zip";
            case 16: return "jcr_source_v6.0.3_16_6019158.zip";
            case 17: return "jcr_source_v6.0.3_17_6455386.zip";
            case 18: return "jcr_source_v6.0.3_18_5723168.zip";
            case 19: return "jcr_source_v6.0.3_19_3189913.zip";
            case 1: return "jcr_source_v6.0.3_1_1264424.zip";
            case 20: return "jcr_source_v6.0.3_20_1726161.zip";
            case 21: return "jcr_source_v6.0.3_21_4233383.zip";
            case 22: return "jcr_source_v6.0.3_22_8318142.zip";
            case 23: return "jcr_source_v6.0.3_23_2664734.zip";
            case 24: return "jcr_source_v6.0.3_24_2146719.zip";
            case 25: return "jcr_source_v6.0.3_25_2195239.zip";
            case 26: return "jcr_source_v6.0.3_26_8826010.zip";
            case 27: return "jcr_source_v6.0.3_27_3332013.zip";
            case 28: return "jcr_source_v6.0.3_28_8649522.zip";
            case 29: return "jcr_source_v6.0.3_29_3733179.zip";
            case 2: return "jcr_source_v6.0.3_2_9640841.zip";
            case 30: return "jcr_source_v6.0.3_30_5455306.zip";
            case 31: return "jcr_source_v6.0.3_31_1510312.zip";
            case 32: return "jcr_source_v6.0.3_32_8098115.zip";
            case 33: return "jcr_source_v6.0.3_33_3766521.zip";
            case 34: return "jcr_source_v6.0.3_34_8490263.zip";
            case 35: return "jcr_source_v6.0.3_35_9316417.zip";
            case 36: return "jcr_source_v6.0.3_36_2859755.zip";
            case 37: return "jcr_source_v6.0.3_37_7640217.zip";
            case 38: return "jcr_source_v6.0.3_38_8438005.zip";
            case 39: return "jcr_source_v6.0.3_39_5520984.zip";
            case 3: return "jcr_source_v6.0.3_3_1033954.zip";
            case 40: return "jcr_source_v6.0.3_40_5893749.zip";
            case 41: return "jcr_source_v6.0.3_41_2111994.zip";
            case 42: return "jcr_source_v6.0.3_42_5253526.zip";
            case 43: return "jcr_source_v6.0.3_43_4603084.zip";
            case 44: return "jcr_source_v6.0.3_44_3985393.zip";
            case 45: return "jcr_source_v6.0.3_45_7742242.zip";
            case 46: return "jcr_source_v6.0.3_46_3171887.zip";
            case 47: return "jcr_source_v6.0.3_47_8601882.zip";
            case 48: return "jcr_source_v6.0.3_48_5444647.zip";
            case 49: return "jcr_source_v6.0.3_49_6819291.zip";
            case 4: return "jcr_source_v6.0.3_4_9074155.zip";
            case 50: return "jcr_source_v6.0.3_50_8375408.zip";
            case 51: return "jcr_source_v6.0.3_51_5122191.zip";
            case 52: return "jcr_source_v6.0.3_52_2876728.zip";
            case 53: return "jcr_source_v6.0.3_53_5287876.zip";
            case 54: return "jcr_source_v6.0.3_54_3861282.zip";
            case 55: return "jcr_source_v6.0.3_55_9714174.zip";
            case 56: return "jcr_source_v6.0.3_56_9441279.zip";
            case 57: return "jcr_source_v6.0.3_57_2864278.zip";
            case 58: return "jcr_source_v6.0.3_58_4683902.zip";
            case 59: return "jcr_source_v6.0.3_59_1407726.zip";
            case 5: return "jcr_source_v6.0.3_5_2786639.zip";
            case 60: return "jcr_source_v6.0.3_60_7997481.zip";
            case 61: return "jcr_source_v6.0.3_61_6088696.zip";
            case 62: return "jcr_source_v6.0.3_62_7232994.zip";
            case 63: return "jcr_source_v6.0.3_63_4226209.zip";
            case 64: return "jcr_source_v6.0.3_64_1051323.zip";
            case 65: return "jcr_source_v6.0.3_65_8794111.zip";
            case 66: return "jcr_source_v6.0.3_66_5758215.zip";
            case 67: return "jcr_source_v6.0.3_67_3507945.zip";
            case 68: return "jcr_source_v6.0.3_68_9615193.zip";
            case 69: return "jcr_source_v6.0.3_69_7457658.zip";
            case 6: return "jcr_source_v6.0.3_6_3714159.zip";
            case 70: return "jcr_source_v6.0.3_70_8962260.zip";
            case 71: return "jcr_source_v6.0.3_71_2946610.zip";
            case 72: return "jcr_source_v6.0.3_72_1084071.zip";
            case 73: return "jcr_source_v6.0.3_73_2475006.zip";
            case 74: return "jcr_source_v6.0.3_74_1106374.zip";
            case 75: return "jcr_source_v6.0.3_75_3945107.zip";
            case 76: return "jcr_source_v6.0.3_76_1892892.zip";
            case 77: return "jcr_source_v6.0.3_77_5576954.zip";
            case 78: return "jcr_source_v6.0.3_78_8848382.zip";
            case 79: return "jcr_source_v6.0.3_79_8045688.zip";
            case 7: return "jcr_source_v6.0.3_7_7090643.zip";
            case 80: return "jcr_source_v6.0.3_80_2512179.zip";
            case 81: return "jcr_source_v6.0.3_81_9137810.zip";
            case 82: return "jcr_source_v6.0.3_82_4315734.zip";
            case 83: return "jcr_source_v6.0.3_83_9693146.zip";
            case 84: return "jcr_source_v6.0.3_84_3698318.zip";
            case 85: return "jcr_source_v6.0.3_85_7024019.zip";
            case 86: return "jcr_source_v6.0.3_86_8781497.zip";
            case 87: return "jcr_source_v6.0.3_87_6993821.zip";
            case 88: return "jcr_source_v6.0.3_88_9391125.zip";
            case 89: return "jcr_source_v6.0.3_89_7180166.zip";
            case 8: return "jcr_source_v6.0.3_8_3813037.zip";
            case 90: return "jcr_source_v6.0.3_90_2119544.zip";
            case 91: return "jcr_source_v6.0.3_91_1878095.zip";
            case 92: return "jcr_source_v6.0.3_92_6603604.zip";
            case 93: return "jcr_source_v6.0.3_93_1903317.zip";
            case 94: return "jcr_source_v6.0.3_94_7282385.zip";
            case 95: return "jcr_source_v6.0.3_95_1192052.zip";
            case 96: return "jcr_source_v6.0.3_96_5214221.zip";
            case 97: return "jcr_source_v6.0.3_97_3267797.zip";
            case 98: return "jcr_source_v6.0.3_98_5651951.zip";
            case 99: return "jcr_source_v6.0.3_99_5393606.zip";
            case 9: return "jcr_source_v6.0.3_9_2221499.zip";
			
			default: return "jcr_source_v6.0.3_def_0193793.zip";
		}
	}
	*/
	
	// Удаляет 0 в начале строки, т.к. Java не включает 0 в начало строки при генерации хеш-суммы
	function handle_md5($string)
	{
		if (strcasecmp(substr($string, 0, 1), "0") == 0)
			$string = substr($string, 1);
			
		return $string;
	}
	
	function write_to_base($login)
	{
		global $db;
		$temp_key = generate_key();
		$temp_date = date("d-m-Y, H:i:s");
		$query = $db -> query("UPDATE `jcr_updater` SET `temp_key`='$temp_key', `temp_date`='$temp_date' WHERE `login`='$login'") or die($db -> error);
		return $temp_key;
	}
	
	function delete_from_base($login)
	{
		global $db, $source_version, $source_version, $source_ver, $downloads;
		
		if (strcasecmp($source_ver, $source_version) == 0) $downloads++; else $downloads = 1;
		$query = $db -> query("UPDATE `jcr_updater` SET `temp_key`='null', `source_version`='$source_version', `downloads_number`='$downloads' WHERE `login`='$login'") or die($db -> error);
	}
	
	function check_time($date_time)
	{
		$real_date	= date("d-m-Y"); $split_rdate = explode("-", $real_date);
		$real_time	= date("H:i:s"); $split_rtime = explode(":", $real_time);
		
		$da_time	= explode(", ", $date_time);
		$date		= $da_time[0]; $split_date = explode("-", $date);
		$time 		= $da_time[1]; $split_time = explode(":", $time);
		
		$timestamp	= (mktime($split_time[0], $split_time[1], $split_time[2], $split_date[1],  $split_date[0],  $split_date[2]));
		$rtimestamp	= (mktime($split_rtime[0], $split_rtime[1], $split_rtime[2], $split_rdate[1],  $split_rdate[0],  $split_rdate[2]));
		$difference	= floor(($rtimestamp - $timestamp) / 1); /* 1 - секунда, 60 - минута, 3600 - час, 86400 - день, 604800 - неделя, 31536000 - год */
		
		return $difference;
	}
	
	function generate_key()
	{
		srand(time());
		$randNum = rand(1000000000, 2147483647).rand(1000000000, 2147483647).rand(0, 9);
		return $randNum;
	}
	
	function generate_code()
	{
		srand(time());
		$randNum = rand(10000, 21474).rand(10000, 21474).rand(0, 9);
		return $randNum;
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