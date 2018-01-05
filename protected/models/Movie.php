<?php

class Movie extends ActiveRecord
{
	public function tableName()
	{
		return 'movie';
	}

	public function rules()
	{
		return array(
			array('name, director, release_year, image, imdb_link', 'required'),
			array('name, director', 'length', 'max'=>100),
			array('image, imdb_link', 'length', 'max'=>200),
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

	public static function random($from = 1900, $to = 2100)
	{
		$q = new CDbCriteria;
		$q->addBetweenCondition('release_year', $from, $to);
		$max = self::model()->count($q)-1;
		$offset = rand(0,$max);
		$q->offset = $offset;
		return self::model()->find($q);
	}

	public function isDouble()
	{
		$m = self::findOne(['name'=>$this->name,'release_year'=>$this->release_year]);
		if ($m) return true;
		return false;
	}
}
