<?php
	if(!defined('IMPASS_CHECK')) die("You don't have permissions to run this");

/*
	���� ������� ����������� ������ ��� ���������� � ���������� ���������, cms, ��������... :
	
	'hash_md5' 			- md5 �����������
	'hash_authme'   	- ���������� � �������� AuthMe
	'hash_cauth' 		- ���������� � �������� Cauth
	'hash_xauth' 		- ���������� � �������� xAuth
	'hash_joomla' 		- ���������� � Joomla (v1.6 - v1.7)
	'hash_ipb' 			- ���������� � IPB
	'hash_xenforo' 		- ���������� � XenForo (�� v1.2)
	'hash_wordpress' 	- ���������� � WordPress
	'hash_vbulletin' 	- ���������� � vBulletin
	'hash_dle' 			- ���������� � DLE
	'hash_drupal'     	- ���������� � Drupal (v7)
	'hash_webmcr'     	- ���������� � webMCR (v2.35)
*/
	$crypt				= 'hash_wordpress'; 			// ���������� (������� ����)
	
	$db_host			= 'localhost';					// Ip-����� ���� ������
	$db_port			= '3306';						// ���� ���� ������
	$db_user			= 'user';						// ������������ ���� ������
	$db_pass			= 'password';					// ������ ���� ������
	
/*
	$db_database - ��� ���� ������, �������� �� ���������:
	AuthMe = 'authme'
	xAuth = ����������� (����������� �������)
	CAuth = 'cauth'
	Joomla, IPB, XenForo, WordPress, vBulletin, DLE, Drupal, webMCR - ����������� (����������� �������)
*/
	$db_database		= 'database';					// ���� ������
	$encoding			= 'cp1251';						// ��������� ���� ������: cp1251 or UTF8 ...
	
/*
	$db_table - ������� ���� ������, �������� �� ���������:
	AuthMe = 'authme'
	xAuth = 'accounts'
	CAuth = 'users'
	Joomla = '�������_users' - ������ 'y3wbm_users', ��� "y3wbm_" - �������. ���������� ������� ����� ������������� - ������ 'users'
	IPB = 'members'
	XenForo = '�������_user' - ������ 'xf_user', ��� "xf_" - �������. ���������� ������� ����� ������������� - ������ 'user'
	vBulletin = '�������_user' - ������ 'bb_user', ��� "bb_" - �������. ���������� ������� ����� ������������� - ������ 'user'
	WordPress = '�������_users' - ������ 'wp_users', ��� "wp_" - �������. ���������� ������� ����� ������������� - ������ 'users'
	DLE = '�������_users' - ������ 'dle_users', ��� "dle_" - �������. ���������� ������� ����� ������������� - ������ 'users'
	Drupal = '�������_users' - ������ 'drupal_users', ��� "drupal_" - �������. ���������� ������� ����� ������������� - ������ 'users'
	webMCR = 'accounts'
*/
	$db_table			= 'wp_users';					// ������� � ��������������
	
/*
	$db_colId - ���������� �������������, �������� �� ���������
	AuthMe = 'id'
	xAuth = 'id'
	CAuth = 'id'
	Joomla = 'id'
	IPB = 'member_id'
	XenForo = 'user_id'
	vBulletin = 'userid'
	WordPress = 'id'
	DLE = 'user_id'
	Drupal = 'uid'
	webMCR = 'id'
*/
	$db_colId			= 'id';							// ������� � ID �������������
	  
/*
	$db_colUser - ������� ������, �������� �� ���������:
	AuthMe = 'username'
	xAuth = 'playername'
	CAuth = 'login'
	Joomla = 'name'
	IPB = 'name'
	XenForo = 'username'
	vBulletin = 'username'
	WordPress = 'user_login'
	DLE = 'name'
	Drupal = 'name'
	webMCR = 'login'
*/
	$db_colUser		= 'user_login';						// ������� � ������� �������������
	  
/*
	$db_colPass - ������� ������, �������� �� ���������:
	AuthMe = 'password'
	xAuth = 'password'
	CAuth = 'password'
	Joomla = 'password'
	IPB = 'members_pass_hash'
	XenForo = 'data'
	vBulletin = 'password'
	WordPress = 'user_pass'
	DLE = 'password'
	Drupal = 'pass'
	webMCR = 'password'
*/
	$db_colPass		= 'user_pass';						// ������� � �������� �������������
	
	$db_colSalt		= 'members_pass_salt';				// ��������� ��� IPB (members_pass_salt) � vBulletin (salt)
	$db_tableOther	= 'xf_user_authenticate';			// ���. ������� ��� ���������� � XenForo
	
	
	$db_colSesId	= 'sesId';							// �� �������, ������� � �������� �������������
	$db_colServer	= 'serverId';						// �� �������, ������� � ��������� �������������
	$db_colHWID		= 'HWID';							// �� �������, ������� � HWID ������������
	$db_colBlHWIDs	= 'blockedHWIDs';					// �� �������, ������� � ���������������� HWID
	$db_colAuthId	= 'authSesId';						// �� �������, ������� � �������� ��� �����������
	$db_colUUID		= 'UUID';							// �� �������, ������� � UUID ������������
	$db_colUserStat	= 'userStatus';						// �� �������, ������� �� �������� ������������
	
	
 /** **************************** Connect to the server - DO NOT TOUCH! **************************** **/
 /** *********************************************************************************************** **/
 
	$db = new mysqli($db_host, $db_user, $db_pass, $db_database, $db_port);
	if ($db -> connect_error) die('Connection Error (' . $db -> connect_errno . ') ' . $db -> connect_error);
	
	$db -> query("SET names ".$encoding." COLLATE cp1251_general_ci");
?>