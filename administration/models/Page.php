<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property integer $parent_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Page extends Content {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Content the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function defaultScope()
	{
		return array(
			'condition'=>"type='page'",
		);
	}

	

	public function listParent() {
        	$pages = self::model()->findAll();
        	$parentList = CHtml::listData($pages, 'id', 'title');
        	return $parentList;
    	}
	public function beforeSave(){
      		$this->type="page";
      		return parent::beforeSave();
      } 
    
}
