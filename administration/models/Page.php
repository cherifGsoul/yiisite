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
class Page extends CActiveRecord {
    const STATUS_DRAFT=1;
    const STATUS_PUBLISHED=2;
    const STATUS_DELETED=3;

    /**
     * Returns the static model of the specified AR class.
     * @return Page the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{page}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('status', 'in', 'range' => array(1, 2, 3)),
            array('title', 'length', 'max' => 125),
            array('content,slug', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('title, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent'=>array(self::BELONGS_TO, 'Page','parent_id'),
            'childs'=>array(self::HAS_MANY,'Page','parent_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'slug' => 'Slug',
            'parent_id' => 'Parent',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'user_id' => 'User',
            'update_user_id' => 'Update User',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('status', $this->status);
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
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
            'tree' => array(
               'class' => 'ext.behaviors.models.ENestedSetBehavior',
               'rootAttribute'=>'parent_id',
               'leftAttribute' => 'lft',
               'rightAttribute' => 'rght',
               'levelAttribute' => 'level',
               'hasManyRoots'=>true,
            ),
            
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'create_time',
				'updateAttribute' => 'update_time',
				'setUpdateOnCreate'=>true,
			)
        );
    }

    public function getUrl() {
        return Yii::app()->createUrl('page/view', array(
            'id' => $this->id,
            'slug' => $this->slug,
        ));
    }

    public function listParent() {
        $pages = self::model()->findAll();
        $parentList = CHtml::listData($pages, 'id', 'title');
        return $parentList;
    }

   public function beforeSave(){
      $this->user_id=$this->update_user_id=Yii::app()->user->id;
      return parent::beforeSave();
      } 
}