
	/* Добавление значений sesId и serverId в таблицу */
	
	ALTER TABLE table_name
	ADD sesId varchar(255) DEFAULT NULL,
	ADD serverId varchar(255) DEFAULT NULL,
	ADD HWID varchar(255) DEFAULT NULL,
	ADD blockedHWIDs varchar(255) DEFAULT NULL,
	ADD authSesId varchar(255) DEFAULT NULL,
	ADD UUID varchar(255) DEFAULT NULL,
	ADD userStatus int(9) NOT NULL DEFAULT '0';