<?php

	$pw = $_POST[pw];

	echo '[ Input String ]<br>';
	echo '�Էµ� �н����� = ' .$pw. '<br><br>';

	dl("test.so");
	
	$len = strlen($pw);
	
	$class = 0;
	$digit = 0;
	$upper = 0;
	$lower = 0;
	$other = 0;
	
	for($i = 0; $i < $len; $i++)
	{
		if(ctype_digit($pw[$i]) && $num == 0)
		{
			$class++;
			$num = 1;
		}
		if(ctype_upper($pw[$i]) && $upper == 0)
		{
			$class++;
			$upper = 1;
		}
		if(ctype_lower($pw[$i]) && $lower == 0)
		{
			$class++;
			$lower = 1;
		}
		if(!ctype_digit($pw[$i]) && !ctype_upper($pw[$i]) && !ctype_lower($pw[$i]) && $other == 0)
		{
			$class++;
			$other = 1;
		}
	}
	
	if($len <= 7) $result = 1;
	else if($len >= 15) $result = 4;
	else
	{
		$result = 3;
		if($len <= 14 && $len >= 10; $class == 1) $result = 2;
		else if($len == 9)
		{
			if($class == 1) $result = 1;
			else if($class == 2) $result = 2;
		}
		else if($class <= 2) $result = 1;
	}
		
	$output = foo($pw);
	
	echo '[ Resulting Sequence ]<br>';
	echo $output. '<br><br>';

	echo '[ Reporting ]<br>';
	if($output > 0)
	{
		$chars = ($output >> 28) & 0x0f;
		$length = ($output >> 20) & 0xff;
		$level = ($output >> 16) & 0x0f;
		$etc = ($output & 0xffff);
	
		echo 'Charset : '.$chars.'<br>';
		echo 'Length : '.$length.'<br>';
			
		if(($etc & 0x0001) == 0x0001) echo '���� �� ���� ������ �ִ� �ܾ ���ԵǾ� �ֽ��ϴ�.<br>';
		if(($etc & 0x0010) == 0x0010) echo '�н������� ���̰� '.$length.'�̹Ƿ� ª���ϴ�.<br>';
		if(($etc & 0x0100) == 0x0100) echo '�ݺ��Ǵ� ���ڿ��� ���ԵǾ� �ֽ��ϴ�.<br>';
		if(($etc & 0x1000) == 0x1000) echo '���� ���������� ������ '.$chars.'�����̹Ƿ� �����ϴ�.<br>';
	}
	echo '<br><br>';

	echo '[ Resulting by Password Guideline ]<br>';
	if ($level == 0x01) echo '�н����� ��� : ��<br>';
	if ($level == 0x02) echo '�н����� ��� : ��<br>';
	if ($level == 0x03) echo '�н����� ��� : ��<br>';
	if ($level == 0x04) echo '�н����� ��� : �ֻ�<br>';
?>