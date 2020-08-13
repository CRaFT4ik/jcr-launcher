	
	/* Таблица с данными, необходимыми для получения обновления JCR Launcher */
	
	CREATE TABLE IF NOT EXISTS jcr_updater (
		`id` INT NOT NULL AUTO_INCREMENT,
		`created` CHAR(10) NOT NULL,
		`login` VARCHAR(50) NOT NULL,
		`password` VARCHAR(50) NOT NULL,
		`key` CHAR(24) NOT NULL,
		`temp_key` VARCHAR(50) NOT NULL,
		`temp_date` VARCHAR(20) NOT NULL,
		`source_version` VARCHAR(50) NOT NULL,
		`downloads_number` int(9) NOT NULL DEFAULT '0',
		PRIMARY KEY ( `id` )
	) ENGINE=MyISAM CHARACTER SET=utf8;

	INSERT INTO jcr_updater (`id`, `created`, `login`, `password`, `key`, `temp_key`, `temp_date`, `source_version`, `downloads_number`) VALUES
		(1, '13.02.2012', 'CRaFT4ik', 'password', '5AU7MF177V6O2C16HOOB12S6', 'temp_key', '26-05-2013, 23:59:59', 'no', '0');