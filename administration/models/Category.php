<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $parent_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $user_id
 * @property integer $update_user_id
 * @property string $meta_keys
 * @property string $meta_description
 *
 * The followings are the available model relations:
 * @property User $user
 * @property User $updateUser
 * @property Content[] $tblContents
 */
class Category extends Taxonomy 
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function defaultScope(){
		return array(
			'condition'=>"type='category'",
		);
	}
	
	public function listParent() {
        	$categories = self::model()->findAll();
        	$parentList = CHtml::listData($categories, 'id', 'title');
        	return $parentList;
    	}

}
