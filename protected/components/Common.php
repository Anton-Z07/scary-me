<?php

class Common
{
	private static $user = false;

	static function normalizePhone($phone_str)
	{
		if (!$phone_str) return '';
		$phone = '';
		for ($i=0; $i<strlen($phone_str); $i++)
		{
			if (is_numeric($phone_str[$i]))
				$phone .= $phone_str[$i];
		}
		if (($phone[0] == '7' || $phone[0] == '8') && strlen($phone) > 10)
			$phone = substr($phone, 1);
		if ($phone)
		{
			while (strlen($phone) < 10)
				$phone = '0' . $phone;
			$phone = '8(' . substr($phone, 0, 3) . ')' . substr($phone, 3, 3) . '-' . substr($phone, 6, 2) . '-' . substr($phone, 8, 2);
		}
		return $phone;
	}

	public static function getReadableDate($date, $need_time = false, $need_day_of_week = false)
	{
		$months = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 
			'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
		$days = array('Sunday' => 'воскресенье', 'Monday' => 'понедельник', 'Tuesday' => 'вторник', 
			'Wednesday' => 'среда', 'Thursday' => 'четверг', 'Friday' => 'пятница', 'Saturday' => 'суббота', );
		$m = date('n', strtotime($date));
		$str = '';
		$str .= date('d ' . $months[$m-1], strtotime($date));
		if ($need_day_of_week) $str .= ', ' . $days[date('l',  strtotime($date))];
		if ($need_time) $str .= ' ' . date('H:i ',  strtotime($date));
		return $str;
	}

	public static function GetMonths()
	{
		return array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 
			'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
	}

	public static function getDateRu($date)
	{
		if (!$date) return '';
		return date('d.m.Y', strtotime($date));
	}

	public static function TranslateDate($date)
	{
		if (substr_count($date, '.') == 2)
		{
			$datetime = DateTime::createFromFormat('d.m.Y', $date);
			return $datetime->format('Y-m-d');
		}
		return ($date);
	}

	public static function GetPeriod($period)
	{
		$month_arr = array(1 => 'месяц', 2 => 'месяца', 3 => 'месяца', 4 => 'месяца', 5 => 'месяцев', 6 => 'месяцев', 
			7 => 'месяцев', 8 => 'месяцев', 9 => 'месяцев', 10 => 'месяцев', 11 => 'месяцев', 12 => 'месяцев');
		$week_arr = array(1 => 'неделя', 2 => 'недели', 3 => 'недели', 4 => 'недели');
		$days_arr = array(1 => 'день', 2 => 'дня', 3 => 'дня', 4 => 'дня', 5 => 'дней', 6 => 'дней');
		$res = '';
		if ($period >= 365)
		{
			$years = floor($period / 365);
			$res .= $years;
			if ($years == 1)
				$res .= ' год';
			elseif ($years >= 2 && $years <= 4)
				$res .= ' года';
			else
				$res .= ' лет';
			$period = $period % 365;
		}
		if ($period >= 30)
		{
			if ($res) $res .= ' ';
			$months = floor($period / 30);
			$res .= $months . ' ' . $month_arr[$months];
			$period = $period % 30;
		}
		if ($period >= 7)
		{
			if ($res) $res .= ' ';
			$weeks = floor($period / 7);
			$res .= $weeks . ' ' . $week_arr[$weeks];
			$period = $period % 7;
		}
		if ($period)
		{
			if ($res) $res .= ' ';
			$res .= $period . ' ' . $days_arr[$period];
		}
		return $res;
	}

	public static function log($str, $path)
	{
		self::checkLogFile($path);
		$str = date('d.m.Y H:i:s. ') . $str . " \r\n";
		$f = fopen($_SERVER['DOCUMENT_ROOT'] . "/logs/$path", 'a');
		fwrite($f, $str );
		fclose($f);
	}

	private static function checkLogFile($path)
	{
		// Макс. размер лог-файла
		$max_file_size = 3;
		$dirname = "backups";
		$format = "zip";
		$root = $_SERVER['DOCUMENT_ROOT']."/logs";

		// Если файл не существует
		if (!file_exists("$root/$path"))
			return;
		// Если размер файла актуален
		if (round(filesize("$root/$path")/1024/1024) <= $max_file_size)
			return;

		// Если директория архивов не найдена, создать ее
		if (is_dir("$root/$dirname") === FALSE)
			mkdir("$root/$dirname", 0777);

		$new_file_name = (string)Date("Y-m-d_H-i-s");
		$pathes = explode(".", $path);
		$new_format = $pathes[count($pathes)-1];
		unset($pathes[count($pathes)-1]);
		$source_name = implode(".", $pathes);

		$zip = new ZipArchive();

		// Если условия позволяют работать с zip
		if ($zip->open("$root/$dirname/$source_name.$format", ZipArchive::CREATE) === TRUE)
		{
			// Создание архива
			$zip->addFile("$root/$path", "$new_file_name.$new_format");
			$zip->close();
			unlink("$root/$path");
		}
	}

	public static function LogRequest($path)
	{
		$s = "POST-данные: \r\n<br />";
		foreach ($_POST as $key => $value) {
			if (is_array($value))
			{ 
				$s .= "$key [array]:";
				foreach ($value as $k => $v)
					$s .= " - $k => $v \r\n<br />";
			}
			else
				$s .= "$key => $value \r\n<br />";
		}
		$s .= "\r\n<br />GET-данные: \r\n<br />";
		foreach ($_GET as $key => $value) {
			$s .= "$key => $value \r\n<br />";
		}
		self::Log($s, $path);
	}

	public static function GetInTranslit($string) 
	{
		$replace=array(
			"'"=>"",
			"`"=>"",
			"а"=>"a","А"=>"a",
			"б"=>"b","Б"=>"b",
			"в"=>"v","В"=>"v",
			"г"=>"g","Г"=>"g",
			"д"=>"d","Д"=>"d",
			"е"=>"e","Е"=>"e",
			"ж"=>"zh","Ж"=>"zh",
			"з"=>"z","З"=>"z",
			"и"=>"i","И"=>"i",
			"й"=>"y","Й"=>"y",
			"к"=>"k","К"=>"k",
			"л"=>"l","Л"=>"l",
			"м"=>"m","М"=>"m",
			"н"=>"n","Н"=>"n",
			"о"=>"o","О"=>"o",
			"п"=>"p","П"=>"p",
			"р"=>"r","Р"=>"r",
			"с"=>"s","С"=>"s",
			"т"=>"t","Т"=>"t",
			"у"=>"u","У"=>"u",
			"ф"=>"f","Ф"=>"f",
			"х"=>"h","Х"=>"h",
			"ц"=>"c","Ц"=>"c",
			"ч"=>"ch","Ч"=>"ch",
			"ш"=>"sh","Ш"=>"sh",
			"щ"=>"sch","Щ"=>"sch",
			"ъ"=>"","Ъ"=>"",
			"ы"=>"y","Ы"=>"y",
			"ь"=>"","Ь"=>"",
			"э"=>"e","Э"=>"e",
			"ю"=>"yu","Ю"=>"yu",
			"я"=>"ya","Я"=>"ya",
			"і"=>"i","І"=>"i",
			"ї"=>"yi","Ї"=>"yi",
			"є"=>"e","Є"=>"e"
		);
		return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
	}

	public static function num2str($num, $with_units = false) 
	{
	    $nul='ноль';
	    $ten=array(
	        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
	        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	    );
	    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	    $unit=array( // Units
	        array('копейка' ,'копейки' ,'копеек',	 1),
	        array('рубль'   ,'рубля'   ,'рублей'    ,0),
	        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
	        array('миллион' ,'миллиона','миллионов' ,0),
	        array('миллиард','милиарда','миллиардов',0),
	    );

	    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	    $out = array();
	    if (intval($rub)>0) {
	        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
	            if (!intval($v)) continue;
	            $uk = sizeof($unit)-$uk-1; // unit key
	            $gender = $unit[$uk][3];
	            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));

	            $out[] = $hundred[$i1]; # 1xx-9xx
	            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3];
	            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3];
	            // units without rub & kop
	            if ($uk>1) $out[]= self::morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
	        }
	    }
	    else $out[] = $nul;

	    if($with_units)
	    {
	    	$out[] = self::morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	    	$out[] = $kop.' '.self::morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]);
	    }

	    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
	}

	public static function morph($n, $f1, $f2, $f5) {
	    $n = abs(intval($n)) % 100;
	    if ($n>10 && $n<20) return $f5;
	    $n = $n % 10;
	    if ($n>1 && $n<5) return $f2;
	    if ($n==1) return $f1;
	    return $f5;
	}

	public static function firstToUpper($word)
	{
		$word = mb_strtolower($word);
		return mb_strtoupper(mb_substr($word, 0, 1)).mb_substr($word, 1, mb_strlen($word));
	}

	public static function daysToWeeks($days)
	{
		return round($days / 7);
	}

	public static function getUser()
	{
		if (self::$user !== false)
			return self::$user;
		self::$user = User::model()->findByPk(Yii::app()->user->userId);
		return self::$user;
	}

	public static function formatNumber($n)
	{
		return number_format($n, 0, '.', ' ');
	}

	public static function getWordForm($n, $w1, $w2, $w3)
	{
		$n = "$n";
		$last_digit = $n[strlen($n)-1];
		if (strlen($n) >= 2)
		{
			$last_two_digits = $n[strlen($n)-2] . $n[strlen($n)-1];
			if (in_array($last_two_digits, ['11', '12', '13', '14', '15', '16', '17', '18', '19'])) return $w3;
		}
		if (in_array($last_digit, ['0', '5', '6', '7', '8', '9'])) return $w3;
		if ($last_digit == '1') return $w1;
		if (in_array($last_digit, ['2', '3', '4'])) return $w2;
	}

	public static function setFlash($text)
	{
		list($url, $params) = array_merge( explode( '?', $_SERVER['REQUEST_URI'] ), array( '' ) );
		$cookie = new CHttpCookie($url, $text);
        $cookie->expire = time()+60*60; 
        Yii::app()->request->cookies[$url] = $cookie;
	}

	public static function getFlash()
	{
		list($url, $params) = array_merge( explode( '?', $_SERVER['REQUEST_URI'] ), array( '' ) );
		if (isset(Yii::app()->request->cookies[$url]))
		{
			$text = Yii::app()->request->cookies[$url]->value;
			unset(Yii::app()->request->cookies[$url]);
			return $text;
		}
		return '';
	}
}