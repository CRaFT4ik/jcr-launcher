<html>
<head>
    <title>JCR Updater :: Add new user</title>
</head>
<body>
<form action="jcr_admin.php?action=adduser" method="post">
    <table>
        <tr><td>Логин администратора<td><input name="admin_login" maxlength="50" size="30">
        <tr><td>Пароль администратора<td><input name="admin_pass" type="password" maxlength="50" size="30">
        <tr><td>Логин<td><input name="login" maxlength="50" size="30">
        <tr><td>Пароль<td><input name="password" maxlength="50" size="30">
		
        <tr><td colspan="2"><input type="submit" value="Добавить логин">
    </table>
</form>
</body>
</html>

<?php
	
	define("IMPASS_CHECK", true);
	
	include("../jcr_connect.php");
	
	$action			= $_GET['action'];
	$admin_login	= sql_param($_POST['admin_login']);
	$admin_pass		= sql_param($_POST['admin_pass']);
	$login			= sql_param($_POST['login']);
	$password		= sql_param($_POST['password']);
	
	$real_admin_login	= "CRaFT4ik";
	$real_admin_pass	= "EldarTim321";
	
	if ($action == "adduser")
	{
		if ($admin_login == $real_admin_login && $admin_pass == $real_admin_pass)
		{
			if ($password == "") $password = generate_password(); $key = generate_key();
			if (!$login || !$password || !$key) die("Не все поля заполненны");
			
			$login			= addslashes(trim($login));
			$password		= addslashes(trim($password));
			$key			= addslashes(trim($key));
			
			$check_query	= $db -> query("SELECT `login` FROM `jcr_updater` WHERE `login` like '%".$login."%'") or die($db -> error);
			$num			= $check_query -> num_rows;
			
			for($i = 0; $i < $num; $i++)
			{
				$row = $check_query -> fetch_array;
				if (strtolower($row["login"]) == strtolower($login)) die("Введенный логин уже зарегестрирован");
			}
			
			$query2			= $db -> query("INSERT INTO `jcr_updater` VALUES ('', '".date("d-m-Y")."', '".$login."', '".$password."', '".$key."', 'null', '".date("d-m-Y, H:i:s")."', 'no', '0')") or die($db -> error);
			
			if ($query2) echo
				"Пользователь добавлен в базу данных:<br />
				JCR Updater: http://www.er-log.ru/JCR_Launcher/updater/jcr_updater.jar<br />
				Логин: $login<br />
				Пароль: $password<br />
				Ключ восстановления: $key<br />
				Ссылка на добавление доменных имен: http://www.er-log.ru/JCR_Launcher/updater/jcr_user.php<br />
				Ссылка на инструкцию: http://www.er-log.ru/?p=128<br />
				Убедительно просим записать эти данные. Не забудьте добавить ваши доменные имена в список, подав заявку по ссылке выше!
				";
			
			$db -> close;
			
		} else
		{
			die("Неверный логин или пароль администратора");
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
	
	function generate_password()
	{
		srand(time());
		$randNum = rand(1000000000, 9999999999);
		return $randNum;
	}
	
	function generate_key()
	{
		srand(time());
		$randNum = rand(10000, 99999)."-".rand(10000, 99999)."-".rand(10000, 99999)."-".rand(100000, 999999);
		return $randNum;
	}
?>
