<?php

	die("<b>Валидация доменных имен прекратила свою работу.</b> В последней версии исходников полностью убран код валидации вашего доменного имени.");

/*



<html>
<head>
    <title>JCR Updater :: Add new user</title>
</head>
<body>
<form action="jcr_user.php?action=add_domain" method="post">
    <table>
		<b>Заявка на добавление доменного имени в список для пользователей JCR Updater:</b><br>
		* Каждое доменное имя писать с новой строки в соответствующем поле<br>
		* Не стоит писать поддомены (sub.example.com), пишите только основной домен (example.com)<br>
		* Если вы указали более 3-х доменов, рассматриваться будут только первые 3<br>
		* Если вы решили добавить домен / изменить его, указывайте все 3 домена в одном сообщении<br>
		* Ваш аккаунт будет заблокирован, если вы совершите попытки спама<br><br>
		* Домены для локального использования: <b>localhost</b> и <b>launcher.jcr</b><br><br>
        <tr><td>Логин от JCR Updater<td><input name="user_login" maxlength="50" size="30">
        <tr><td>Пароль от JCR Updater<td><input name="user_pass" type="password" maxlength="50" size="30">
		<tr><td>Логин Skype (с которого совершена покупка)<td><input name="skype" maxlength="50" size="30">
        <tr><td>Домены (максимум 3)<td><textarea name="domains" cols="24" rows="3"></textarea>
		
        <tr><td colspan="2"><input type="submit" value="Отправить заявку">
    </table>
</form>
</body>
</html>

<?php
	
	define("IMPASS_CHECK", true);
	
	include("../jcr_connect.php");
	
	$action		= $_GET['action'];
	$user_login	= $db -> real_escape_string($_POST['user_login']);
	$user_pass	= $db -> real_escape_string($_POST['user_pass']);
	$skype		= $_POST['skype'];
	$domains	= $_POST['domains'];
	
	$email		= "eldar.tim@gmail.com";
	
	if ($action == "add_domain")
	{
		if ($user_login == null || $user_pass == null || $skype == null || $domains == null) die ("Не все поля заполнены");
		
		$query = $db -> query("SELECT `login`, `password` FROM `jcr_updater` WHERE `login`='$user_login'") or die($db -> error);
		
		if ($query -> num_rows == 1)
		{
			$row		= $query -> fetch_assoc();
			$real_login	= $row["login"];
			$real_pass	= $row["password"];
			
			if (strcmp($user_pass, $real_pass) != 0) die ("Неверный логин или пароль");
		} else
		{
			die ("Неверный логин или пароль");
		}
		
		$mail = mail
		(
			$email,
			"[JCR] ".$real_login." - Добавление доменных имен",
			"Логин: ".$real_login."; Skype: ".$skype."\nДоменные имена:\n".$domains
		);
		
		if ($mail)
		{
			echo "<meta http-equiv=\"refresh\" content=\"2; url=jcr_user.php\">";
			die ("Заявка успешно отправлена! Сейчас вас перенаправят.");
		} else
		{
			die ("Не удалось отправить заявку, попробуйте снова");
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



*/



?>
