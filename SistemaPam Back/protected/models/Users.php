<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string gender
 * @property string $address
 * @property integer $code_id
 * @property string $ci
 * @property datetime $updated_on
 * @property datetime $created_on
 * @property boolean $deleted
 */
 
class Users extends CActiveRecord{
        
        public $code;
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Users';
                case 'singular': return 'User';
                case 'pluralCamelCase': return 'users';
                case 'singularCamelCase': return 'user';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name,gender,phone, email,address, code_id, ci, updated_on, created_on, deleted, ', 'required'),
                        array('code_id', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('updated_on, created_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('email, ', 'email'),
                        array('first_name, last_name, phone, ci', 'length', 'max'=>128),
                        array('id, first_name, last_name, phone, email, code_id, ci, updated_on, created_on, deleted', 'safe', 'on'=>'search'),
                );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
			'id' => 'ID',
                        'first_name' => 'first_name',
                        'last_name' => 'last_name',
                        'gender' => 'gender',
                        'phone' => 'Phone',
                        'email' => 'Email',
                        'code_id' => 'Code',
                        'ci' => 'ci',
                        'address'=>'Address',
                        'updated_on' => 'UpdatedOn',
                        'created_on' => 'CreatedOn',
                        'deleted' => 'Deleted',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'first_name': return 'first_name';
                        case 'last_name': return 'last_name';
                        case 'gender': return 'gender';
                        case 'phone': return 'Phone';
                        case 'email': return 'Email';
                        case 'address': return 'Address';
                        case 'code_id': return 'Code';
                        case 'ci': return 'ci';
                        case 'updated_on': return 'UpdatedOn';
                        case 'created_on': return 'CreatedOn';
                        case 'deleted': return 'Deleted';
                        
                default: return '';
            }
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
                $criteria->compare('gender',$this->gender,true);
                $criteria->compare('phone',$this->phone,true);
                $criteria->compare('email',$this->email,true);
                $criteria->compare('address',$this->address,true);
                $criteria->compare('code_id',$this->code_id,true);
                $criteria->compare('ci',$this->ci,true);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $user = self::model()->findByPk($id);
            if(isset($user->id))
                return $user;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($first_name, $last_name,$phone, $email,$gender,$address,$code_id, $ci){
            $user = new Users;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->phone = $phone;
            $user->email = $email;
            $user->gender = $gender;
            $user->address = $address;
            $user->code_id = $code_id;
            $user->ci = $ci;
            $user->updated_on = HelperFunctions::getDate();
            $user->created_on = HelperFunctions::getDate();
            $user->deleted = 0;
            if($user->save())
                return $user;
            else{
                Errors::log('Error en Models/Users/create','Error creating user',print_r($user->getErrors(),true));
                return $user;
            }
        }
            
        public static function getCurrent(){
            return false;
        }
            
        public function deleteUser(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Users/deleteUser','Error deleting user id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
                
        public function loadCode(){
            $this->code = Codes::get($this->code_id);
        }  
        
}
?>