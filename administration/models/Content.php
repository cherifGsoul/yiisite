<?php


/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $id
 * @property string $title
 * @property string $type
 * @property string $content
 * @property string $excerpt
 * @property string $slug
 * @property integer $parent_id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $user_id
 * @property integer $update_user_id
 * @property string $meta_description
 * @property string $meta_keys
 * @property string $meta_robots
 *
 * The followings are the available model relations:
 * @property Category[] $tblCategories
 * @property Comment[] $comments
 * @property User $user
 * @property Tag[] $tblTags
 */
class Content extends CActiveRecord
{

	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Content the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{content}}';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, status', 'required'),
			array('status', 'in', 'range'=>array(1,2,3)),
			array('title, meta_robots', 'length', 'max'=>128),
			array('excerpt, meta_description, meta_keys, content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('title, type, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			/*'Categories' => array(self::MANY_MANY, 'Category', '{{category_content}}(content_id, category_id)'),
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id', 'condition'=>'comments.status='.Comment::STATUS_APPROVED, 'order'=>'comments.create_time DESC'),
			'commentCount' => array(self::STAT, 'Comment', 'post_id', 'condition'=>'status='.Comment::STATUS_APPROVED),*/
		
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'taxonomy' => array(self::MANY_MANY, 'Taxonomy', '{{taxonomy_content}}(taxonomy_id, content_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'type' => 'Type',
			'content' => 'Content',
			'excerpt' => 'Excerpt',
			'slug' => 'Slug',
			'parent_id' => 'Parent',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'user_id' => 'User',
			'update_user_id' => 'Update User',
			'meta_description' => 'Meta Description',
			'meta_keys' => 'Meta Keys',
			'meta_robots' => 'Meta Robots',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

     /**
     *
     * @return array
     */
    public function getStatusOptions() {
        return array(
            self::STATUS_DRAFT => "Draft",
            self::STATUS_PUBLISHED => "Published",
            self::STATUS_ARCHIVED => "Archived",
        );
    }

    public function behaviors() {
        parent::behaviors();
        return array(
            'sluggable' => array(
                'class' => 'ext.behaviors.models.SluggableBehavior',
                'columns' => array('title'),
                'unique' => 'true',
                'update' => 'true',
            ),
            
	  'CTimestampBehavior' => array(
		'class' => 'zii.behaviors.CTimestampBehavior',
		'createAttribute' => 'create_time',
		'updateAttribute' => 'update_time',
		'setUpdateOnCreate'=>true,
		),
            'tree' => array(
               'class' => 'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
               'rootAttribute'=>'parent_id',
               'leftAttribute' => 'lft',
               'rightAttribute' => 'rgt',
               'levelAttribute' => 'level',
               'hasManyRoots'=>true
                )
	
        );
    }

	/* public function listParent() {
        $pages = self::model()->findAll();
        $parentList = CHtml::listData($pages, 'id', 'title');
        return $parentList;
    }*/

	public function beforeSave(){
      	$this->user_id=$this->update_user_id=Yii::app()->user->id;
      	return parent::beforeSave();
      } 

	protected function instantiate($attributes)
	{
		switch($attributes['type'])
		{
			case 'post':
			$class='Post';
			break;
			case 'page':
			$class='Page';
			break;
			default:
			$class=  get_class($this);
		}
		$model=new $class(null);
		return $model;
	}	
}
