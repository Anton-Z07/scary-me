<?php

class Post extends ActiveRecord
{
	public function tableName()
	{
		return 'post';
	}

	public function rules()
	{
		return array(
			array('url, title, text', 'required'),
			array('posted', 'numerical', 'integerOnly'=>true),
			array('url, image', 'length', 'max'=>200),
			array('title', 'length', 'max'=>500),
		);
	}

	public function relations()
	{
		return array(
			'images'=>array(self::HAS_MANY, 'Image', 'id_post'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDate()
	{
		return date('F j, Y', strtotime($this->date));
	}

	public function getRecommended()
	{
		$q = new CDbCriteria;
		$q->addCondition("id<>{$this->id}");
		$q->order = "RAND()";
		$q->limit = 4;
		return self::findMany($q);
	}
}
