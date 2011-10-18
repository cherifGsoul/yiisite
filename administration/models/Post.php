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
		return array();
	}*/

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id', 'condition'=>'comments.status='.Comment::STATUS_APPROVED, 'order'=>'comments.create_time DESC'),
			'commentCount' => array(self::STAT, 'Comment', 'post_id', 'condition'=>'status='.Comment::STATUS_APPROVED),
		
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'categories' => array(self::MANY_MANY, 'Taxonomy', '{{content_taxonomy}}(tbl_content_id, tbl_taxonomy_id)'),
		);
	}


		
	


	public function defaultScope()
	{
		return array(
			'condition'=>"type='post'",
		);
	}

/*	public function attributeLabels()
	{
		return array(
			'title' => 'Title',
			'type' => 'Type',
			'content' => 'Content',
			'excerpt' => 'Excerpt',
			'status' => 'Status',
			'categories'=>'Categories',
			'tags'=>'Tags',
			'meta_description' => 'Meta Description',
			'meta_keys' => 'Meta Keyswords',
			'meta_robots' => 'Meta Robots',
		);
	}*/

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}
    
}
