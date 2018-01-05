<?php

class Settings extends CActiveRecord
{
	public function tableName()
	{
		return 'settings';
	}

	public function rules()
	{
		return array(
			array('alias, value', 'required'),
			array('alias', 'length', 'max'=>50),
			array('id, alias, value', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function SetEncoded($alias, $val)
	{
		$setting = self::model()->findByAttributes(['alias'=>$alias]);
		if (!$setting)
		{
			$setting = new self;
			$setting->alias = $alias;
		}
		$setting->value = $val;
		$setting->save();
	}

	public static function Get($alias)
	{
		$setting = self::model()->findByAttributes(['alias'=>$alias]);
		return $setting ? $setting->value : '';
	}

	public static function GetDecoded($alias)
	{
		$setting = self::model()->findByAttributes(['alias'=>$alias]);
		return $setting ? json_decode($setting->value) : null;
	}
}
