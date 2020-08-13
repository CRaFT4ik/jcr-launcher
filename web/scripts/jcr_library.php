<?php
	
	$action  = $_GET['action'];
	
	$library = array
	(
		"1.2.5::aj", "1.3.x::am", "1.4.x::an", "1.5.x::an"
	);
	
	if ($action == 'library')
	{
		for($i = 0; $i < count($library); $i++)
		{
			$lfp_array = $library[$i]."<:f:>".$lfp_array;
		} echo substr_replace($lfp_array, "", strrpos($lfp_array, "<:f:>"));
	}
	
	/*
                    report("");
                    report("authData 0: " + authData[0]); // sha1(md5()) хэш extra.zip
                    report("authData 1: " + authData[1]); // md5 хэш minecraft.jar
                    report("authData 2: " + authData[2]); // md5 хэш lwjql.jar
                    report("authData 3: " + authData[3]); // md5 хэш lwjql_util.jar
                    report("authData 4: " + authData[4]); // md5 хэш jinput.jar
                    report("authData 5: " + authData[5]); // sha1 хэш версии
                    report("authData 6: " + authData[6]); // sha1($crypt) хэш пароля
                    report("authData 7: " + authData[7]); // XORencrypt(Ключ защиты сессии (она же сессия авторизации для лаунчера))
                    report("authData 8: " + authData[8]); // 'true' или 'false' совпадения хэша программы
                    report("authData 9: " + authData[9]); // Строка с названиями модов <:f:> и их хэшами <:h:>
                    report("authData 10: " + authData[10]); // Строка с библиотекой полей для патча [Minecraft.class] <:f:> (Версия::Поле)
                    report("authData 11: " + authData[11]); // Ссылка на скин игрока
                    report("authData 12: " + authData[12]); // Ссылка на плащ игрока
					report("authData 13: " + authData[13]); // Строка с названиями модов Forge <:f:> и их хэшами <:h:>
					report("authData 14: " + authData[14]); // Полное название файла программы
					report("authData 15: " + authData[15]); // md5 хэш natives.zip
					report("authData 16: " + authData[16]); // md5 хэш assets.zip
					report("authData 17: " + authData[17]); // Теперь тут строка с названиями библиотек <:f:> и их хэшами <:h:> (ранее: md5 хэш libraries.jar)
					report("authData 18: " + authData[18]); // Теперь тут (sha1(md5()) хэш minecraft.json), т.к. Forge переместился в libraries (раньше было: sha1(md5()) хэш forge.jar)
					report("authData 19: " + authData[19]); // Теперь тут просто NULL, т.к. LiteLoader переместился в libraries (раньше было: sha1(md5()) хэш liteloader.jar)
					report("authData 20: " + authData[20]); // md5 хэш md5 хеш-суммы файла программы
					report("authData 21: " + authData[21]); // 'true', при первой авторизации, 'false' при последующих и если параметр $use_hwid_search неактивен
					report("authData 22: " + authData[22]); // путь_до_конфиг-файла<:h:>его_md5()<:f:>путь_до_конфиг-файла<:h:>его_md5()
					report("authData 23: " + authData[23]); // Ник игрока с учетом регистра
					report("authData 24: " + authData[24]); // Проверяемые файлы: путь_до_файла<:h:>его_md5<:f:>путь_до_файла<:h:>его_md5
					report("authData 25: " + authData[25]); // Можно ли загружать файлы в личном кабинете
					report("authData 26: " + authData[26]); // Можно ли загружать плащи в личном кабинете
					report("authData 27: " + authData[27]); // XORencrypt(перемешивание_строки(UUID пользователя))
                    report("");
	*/
?>