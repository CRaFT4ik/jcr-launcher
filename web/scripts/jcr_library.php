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
                    report("authData 0: " + authData[0]); // sha1(md5()) ��� extra.zip
                    report("authData 1: " + authData[1]); // md5 ��� minecraft.jar
                    report("authData 2: " + authData[2]); // md5 ��� lwjql.jar
                    report("authData 3: " + authData[3]); // md5 ��� lwjql_util.jar
                    report("authData 4: " + authData[4]); // md5 ��� jinput.jar
                    report("authData 5: " + authData[5]); // sha1 ��� ������
                    report("authData 6: " + authData[6]); // sha1($crypt) ��� ������
                    report("authData 7: " + authData[7]); // XORencrypt(���� ������ ������ (��� �� ������ ����������� ��� ��������))
                    report("authData 8: " + authData[8]); // 'true' ��� 'false' ���������� ���� ���������
                    report("authData 9: " + authData[9]); // ������ � ���������� ����� <:f:> � �� ������ <:h:>
                    report("authData 10: " + authData[10]); // ������ � ����������� ����� ��� ����� [Minecraft.class] <:f:> (������::����)
                    report("authData 11: " + authData[11]); // ������ �� ���� ������
                    report("authData 12: " + authData[12]); // ������ �� ���� ������
					report("authData 13: " + authData[13]); // ������ � ���������� ����� Forge <:f:> � �� ������ <:h:>
					report("authData 14: " + authData[14]); // ������ �������� ����� ���������
					report("authData 15: " + authData[15]); // md5 ��� natives.zip
					report("authData 16: " + authData[16]); // md5 ��� assets.zip
					report("authData 17: " + authData[17]); // ������ ��� ������ � ���������� ��������� <:f:> � �� ������ <:h:> (�����: md5 ��� libraries.jar)
					report("authData 18: " + authData[18]); // ������ ��� (sha1(md5()) ��� minecraft.json), �.�. Forge ������������ � libraries (������ ����: sha1(md5()) ��� forge.jar)
					report("authData 19: " + authData[19]); // ������ ��� ������ NULL, �.�. LiteLoader ������������ � libraries (������ ����: sha1(md5()) ��� liteloader.jar)
					report("authData 20: " + authData[20]); // md5 ��� md5 ���-����� ����� ���������
					report("authData 21: " + authData[21]); // 'true', ��� ������ �����������, 'false' ��� ����������� � ���� �������� $use_hwid_search ���������
					report("authData 22: " + authData[22]); // ����_��_������-�����<:h:>���_md5()<:f:>����_��_������-�����<:h:>���_md5()
					report("authData 23: " + authData[23]); // ��� ������ � ������ ��������
					report("authData 24: " + authData[24]); // ����������� �����: ����_��_�����<:h:>���_md5<:f:>����_��_�����<:h:>���_md5
					report("authData 25: " + authData[25]); // ����� �� ��������� ����� � ������ ��������
					report("authData 26: " + authData[26]); // ����� �� ��������� ����� � ������ ��������
					report("authData 27: " + authData[27]); // XORencrypt(�������������_������(UUID ������������))
                    report("");
	*/
?>