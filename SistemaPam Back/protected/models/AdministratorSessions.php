<?php

/**
 * This is the model class for table "administrator_sessions".
 *
 * The followings are the available columns in table 'administrator_sessions':
 * @property integer $id
 * @property integer $administrator_id
 * @property string $session
 * @property date $date
 */
class AdministratorSessions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AdministratorSessions the static model class
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
		return 'administrator_sessions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive administrator inputs.
		return array(
			array('session, administrator_id, date', 'required'),
                        //array('session, administrator_id, date', 'filter', 'filter'=> array(HelperFunctions, 'purify')),
			array('administrator_id', 'numerical', 'integerOnly'=>true),
			array('date', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, session, administrator_id, date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'administrator_id' => 'Administrator',
			'session' => 'Session',
			'date' => 'Date',
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
		$criteria->compare('administrator_id',$this->administrator_id);
		$criteria->compare('session',$this->session, true);
		$criteria->compare('date',$this->date);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function newAdministratorSession($administrator){
            $administratorSession = new AdministratorSessions;
            $administratorSession->administrator_id = $administrator->id;
            $administratorSession->date = HelperFunctions::getDate();
            $administratorSession->session = Yii::app()->session->sessionID;
            $administratorSession->validate();
            $administratorSession->save();
        }
}