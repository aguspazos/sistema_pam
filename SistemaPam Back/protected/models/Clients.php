<?php

/**
 * This is the model class for table "clients".
 *
 * The followings are the available columns in table 'clients':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $code
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 */
 
class Clients extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Clients';
                case 'singular': return 'Client';
                case 'pluralCamelCase': return 'clients';
                case 'singularCamelCase': return 'client';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Clients the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'clients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, phone, code, created_on, updated_on, deleted, ', 'required'),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('name', 'length', 'max'=>128),
                        array('address', 'length', 'max'=>256),
                        array('phone', 'length', 'max'=>32),
                        array('code', 'length', 'max'=>128),
                        array('id, name, address, phone, code, created_on, updated_on, deleted, ', 'safe', 'on'=>'search'),
                        
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
                        'name' => 'Name',
                        'address' => 'Address',
                        'phone' => 'Phone',
                        'code' => 'Code',
                        'created_on' => 'CreatedOn',
                        'updated_on' => 'UpdatedOn',
                        'deleted' => 'Deleted',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'name': return 'Name';
                        case 'address': return 'Address';
                        case 'phone': return 'Phone';
                        case 'code': return 'Code';
                        case 'created_on': return 'CreatedOn';
                        case 'updated_on': return 'UpdatedOn';
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

		$criteria->compare('name',$this->name,true);
                $criteria->compare('address',$this->address,true);
                $criteria->compare('phone',$this->phone,true);
                $criteria->compare('code',$this->code,true);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $client = self::model()->findByPk($id);
            if(isset($client->id))
                return $client;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($name, $address, $phone, $code){
            $client = new Clients;
            $client->name = $name;
            $client->address = $address;
            $client->phone = $phone;
            $client->code = $code;
            $client->created_on = HelperFunctions::getDate();
            $client->updated_on = HelperFunctions::getDate();
            $client->deleted = 0;
            if($client->save())
                return $client;
            else{
                Errors::log('Error en Models/Clients/create','Error creating client',print_r($client->getErrors(),true));
                return $client;
            }
        }
            
        public function updateAttributes($name, $address, $phone, $code){
            $this->name = $name;
            $this->address = $address;
            $this->phone = $phone;
            $this->code = $code;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Clients/updateClient','Error updating client id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteClient(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Clients/deleteClient','Error deleting client id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
}
?>