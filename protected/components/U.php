<?

class U
{
	public static function gp($name, $default=null)
	{
		return Yii::app()->request->getParam($name, $default);
	}

	public static function gi($name, $default=0)
	{
		return intval(self::gp($name, $default));
	}

	public static function id()
	{
		return Yii::app()->user->innerId;
	}
}