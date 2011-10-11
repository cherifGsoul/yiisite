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
class Post extends Content {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Content the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/*public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		//return array(
			
			/*array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),*/

		//);
	//}


	public function defaultScope()
	{
		return array(
			'condition'=>"type='post'",
		);
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}
    
}
