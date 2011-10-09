<?php

/**
 * This is the model class for table "{{taxonomy}}".
 *
 * The followings are the available columns in table '{{taxonomy}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $slug
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $parent_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $update_user_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Content[] $tblContents
 */
class Taxonomy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Taxonomy the static model class
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
		return '{{taxonomy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title, slug', 'length', 'max'=>128),
			array('type', 'length', 'max'=>60),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('title', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'content' => array(self::MANY_MANY, 'Content', '{{taxonomy_content}}(taxonomy_id, content_id)'),
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
			'description' => 'Description',
			'type' => 'Type',
			'slug' => 'Slug',
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'parent_id' => 'Parent',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
			'user_id' => 'User',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/*protected function instantiate ($attributes){
		switch($attributes['type'])
		{
			case 'category':
				$calss='Category';
			break;
			case 'tag':
				$class='Tag';
			break;
			default:
				$class=get_class($this);
		}
		$model=new $class(null);
		return $model;
	}*/
	
	protected function instantiate($attributes)
	{
		switch($attributes['type'])
		{
			case 'category':
				$class='Category';
			break;
			case 'tag':
				$class='Tag';
			break;
			default:
				$class=  get_class($this);
		}
		$model=new $class(null);
		return $model;
	}	

	
	public function behaviors() 
	{
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

	public function beforeSave()
	{
      		$this->user_id=$this->update_user_id=Yii::app()->user->id;
      		return parent::beforeSave();
      	} 


}
