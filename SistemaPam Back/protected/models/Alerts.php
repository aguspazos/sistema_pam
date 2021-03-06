<?php

/**
 * This is the model class for table "alerts".
 *
 * The followings are the available columns in table 'alerts':
 * @property integer $id
 * @property integer $administrator_id
 * @property integer $user_id
 * @property string $title
 * @property string $message
 * @property string $aux
 * @property string $ip
 * @property string $browser
 * @property string $date
 */
class Alerts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Errors the static model class
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
		return 'alerts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('', 'required'),
			array('administrator_id, user_id', 'numerical', 'integerOnly'=>true),
			array('title, browser', 'length', 'max'=>64),
			array('message, aux', 'length', 'max'=>1024),
			array('ip', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, administrator_id, user_id, title, message, aux, ip, browser, date', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'title' => 'Title',
			'message' => 'Message',
			'aux' => 'Aux',
			'ip' => 'Ip',
			'browser' => 'Browser',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('aux',$this->aux,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('browser',$this->browser,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function log($title, $message, $aux){
            $alert = new Alerts;
            $alert->title = $title;
            $alert->message = $message;
            $alert->aux = $aux;
            $alert->administrator_id = 0;
            $alert->user_id = 0;
            $alert->ip = HelperFunctions::getIP();
            $alert->browser = HelperFunctions::getBrowser();
            $alert->date = HelperFunctions::getDate();
            
            if(isset(Yii::app()->session['session_admin_id']))
               $alert->administrator_id = Yii::app()->session['session_admin_id'];
            if(isset(Yii::app()->session['session_user_id']))
               $alert->user_id = Yii::app()->session['session_user_id'];
            
            $alert->validate();
            $alert->save();
            
            $alertEmails = Yii::app()->params['emails']['alerts'];
            $subject = 'Alerta en sitio '.Yii::app()->params['domain'];
            $body = $alert->title.'<br/><br/><br/>'.$alert->message.'<br/><br/><br/>'.$alert->aux.'<br/><br/><br/>'.$alert->date;
            foreach($alertEmails as $email){
				//EmailHelper::sendEmail($subject, $body, $email);
			}
        }
}