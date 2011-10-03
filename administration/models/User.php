<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $full_name
 * @property string $email
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Page[] $pages
 */
class User extends CActiveRecord {

	public $password_repeat;

	const USER_STATUS_ENABLED=1;
	const USER_STATUS_DISABLED=2;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('username, password, full_name, email', 'required'),
		array('create_user_id, update_user_id, status', 'numerical', 'integerOnly' => true),
		array('username, password', 'length', 'max' => 45),
		array('full_name, email', 'length', 'max' => 125),
		array('username,email,full_name', 'unique'),
		array('password', 'compare'),
		array('password_repeat', 'safe'),
		array('status','in','range'=>array(1,2)),
		array('status','default','value'=>2),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, username, password, full_name, email, create_time, update_time, create_user_id, update_user_id, status', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'pages' => array(self::HAS_MANY, 'Page', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_user_id' => 'Create User',
            'update_user_id' => 'Update User',
            'status' => 'Status',
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

		$criteria->compare('id', $this->id);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('full_name', $this->full_name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);
		$criteria->compare('create_user_id', $this->create_user_id);
		$criteria->compare('update_user_id', $this->update_user_id);
		$criteria->compare('status', $this->status);

		return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
		));
	}

	public function behaviors() {
		parent::behaviors();
		return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
		),
		);
	}

	/**
	 *
	 * @return array of User status
	 */

	public function getUserStatusOptions() {
		return array(
		self::USER_STATUS_ENABLED => "Enabled",
		self::USER_STATUS_DISABLED => "Disabled",
		);
	}

	/**
	 * Encrypt password just before written data to the database to avoid
	 * seeing the password encrypted position
	 * @return boolean
	 */
	public function beforeSave() {
		$this->password = $this->encrypt($this->password);
		return parent::beforeSave();
	}

	public function encrypt($value) {
		$key='Gf;B&yXL|beJUf-K*PPiU{wf|@9K9j5?d+YW}?VAZOS%e2c -:11ii<}ZM?PO!96';
		$value=Yii::app()->securityManager->hashData($value,$key);
		return substr($value,0, 40);
	}

}