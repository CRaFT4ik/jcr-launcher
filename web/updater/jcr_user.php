<?php

	die("<b>��������� �������� ���� ���������� ���� ������.</b> � ��������� ������ ���������� ��������� ����� ��� ��������� ������ ��������� �����.");

/*



<html>
<head>
    <title>JCR Updater :: Add new user</title>
</head>
<body>
<form action="jcr_user.php?action=add_domain" method="post">
    <table>
		<b>������ �� ���������� ��������� ����� � ������ ��� ������������� JCR Updater:</b><br>
		* ������ �������� ��� ������ � ����� ������ � ��������������� ����<br>
		* �� ����� ������ ��������� (sub.example.com), ������ ������ �������� ����� (example.com)<br>
		* ���� �� ������� ����� 3-� �������, ��������������� ����� ������ ������ 3<br>
		* ���� �� ������ �������� ����� / �������� ���, ���������� ��� 3 ������ � ����� ���������<br>
		* ��� ������� ����� ������������, ���� �� ��������� ������� �����<br><br>
		* ������ ��� ���������� �������������: <b>localhost</b> � <b>launcher.jcr</b><br><br>
        <tr><td>����� �� JCR Updater<td><input name="user_login" maxlength="50" size="30">
        <tr><td>������ �� JCR Updater<td><input name="user_pass" type="password" maxlength="50" size="30">
		<tr><td>����� Skype (� �������� ��������� �������)<td><input name="skype" maxlength="50" size="30">
        <tr><td>������ (�������� 3)<td><textarea name="domains" cols="24" rows="3"></textarea>
		
        <tr><td colspan="2"><input type="submit" value="��������� ������">
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
		if ($user_login == null || $user_pass == null || $skype == null || $domains == null) die ("�� ��� ���� ���������");
		
		$query = $db -> query("SELECT `login`, `password` FROM `jcr_updater` WHERE `login`='$user_login'") or die($db -> error);
		
		if ($query -> num_rows == 1)
		{
			$row		= $query -> fetch_assoc();
			$real_login	= $row["login"];
			$real_pass	= $row["password"];
			
			if (strcmp($user_pass, $real_pass) != 0) die ("�������� ����� ��� ������");
		} else
		{
			die ("�������� ����� ��� ������");
		}
		
		$mail = mail
		(
			$email,
			"[JCR] ".$real_login." - ���������� �������� ����",
			"�����: ".$real_login."; Skype: ".$skype."\n�������� �����:\n".$domains
		);
		
		if ($mail)
		{
			echo "<meta http-equiv=\"refresh\" content=\"2; url=jcr_user.php\">";
			die ("������ ������� ����������! ������ ��� ������������.");
		} else
		{
			die ("�� ������� ��������� ������, ���������� �����");
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
