<?php

/**
 * This is the model class for table "{{tag}}".
 *
 * The followings are the available columns in table '{{tag}}':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $frequency
 *
 * The followings are the available model relations:
 * @property Content[] $tblContents
 */
class Tag extends Taxonomy
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function defaultScope()
	{
		return array(
			'condition'=>"type='tag'",
		);
	}

	public function beforeSave()
	{
		$this->type="tag";
		return parent::beforeSave();
	}
}
