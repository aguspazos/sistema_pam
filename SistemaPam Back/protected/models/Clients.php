<?php

/**
 * This is the model class for table "clients".
 *
 * The followings are the available columns in table 'clients':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $business_name //name,bn,address,phone,mobile_phone,mail
 * @property string $rut
 * @property string $document
 * @property string $country
 * @property string $department
 * @property string $address
 * @property string $phone
 * @property string $mobile_phone
 * @property string $mail
 * @property string $second_mail
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 */

class Clients extends CActiveRecord
{



    public static function getModelName($type)
    {
        switch ($type) {
            case 'plural':
                return 'Clients';
            case 'singular':
                return 'Client';
            case 'pluralCamelCase':
                return 'clients';
            case 'singularCamelCase':
                return 'client';
            default:
                return '';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Clients the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'clients';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code,name, business_name, rut, document, country, department, address, phone, mobile_phone, mail, second_mail, created_on, updated_on, deleted, ', 'required'),
            array('deleted, ', 'boolean'),
            array('created_on, updated_on, ', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('code', 'length', 'max' => 128),
            array('name', 'length', 'max' => 128),
            array('business_name', 'length', 'max' => 256),
            array('rut', 'length', 'max' => 256),
            array('document', 'length', 'max' => 64),
            array('country', 'length', 'max' => 32),
            array('department', 'length', 'max' => 128),
            array('address', 'length', 'max' => 256),
            array('phone', 'length', 'max' => 32),
            array('mobile_phone', 'length', 'max' => 128),
            array('mail', 'length', 'max' => 128),
            array('second_mail', 'length', 'max' => 128),
            array('id, name, business_name, rut, document, country, department, address, phone, mobile_phone, mail, second_mail, created_on, updated_on, deleted, ', 'safe', 'on' => 'search'),

        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'business_name' => 'BusinessName',
            'rut' => 'Rut',
            'document' => 'Document',
            'country' => 'Country',
            'department' => 'Department',
            'address' => 'Address',
            'phone' => 'Phone',
            'mobile_phone' => 'MobilePhone',
            'mail' => 'Mail',
            'second_mail' => 'SecondMail',
            'created_on' => 'CreatedOn',
            'updated_on' => 'UpdatedOn',
            'deleted' => 'Deleted',

        );
    }


    public static function getAttributeName($name)
    {
        switch ($name) {
            case 'id':
                return 'ID';
            case 'code':
                return  'Code';
            case 'name':
                return 'Name';
            case 'business_name':
                return 'BusinessName';
            case 'rut':
                return 'Rut';
            case 'document':
                return 'Document';
            case 'country':
                return 'Country';
            case 'department':
                return 'Department';
            case 'address':
                return 'Address';
            case 'phone':
                return 'Phone';
            case 'mobile_phone':
                return 'MobilePhone';
            case 'mail':
                return 'Mail';
            case 'second_mail':
                return 'SecondMail';
            case 'created_on':
                return 'CreatedOn';
            case 'updated_on':
                return 'UpdatedOn';
            case 'deleted':
                return 'Deleted';

            default:
                return '';
        }
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('business_name', $this->business_name, true);
        $criteria->compare('rut', $this->rut, true);
        $criteria->compare('document', $this->document, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('department', $this->department, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('mobile_phone', $this->mobile_phone, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('second_mail', $this->second_mail, true);
        $criteria->compare('created_on', $this->created_on);
        $criteria->compare('updated_on', $this->updated_on);
        $criteria->compare('deleted', $this->deleted);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public static function get($id)
    {
        $client = self::model()->findByPk($id);
        if (isset($client->id))
            return $client;
        else
            return false;
    }

    public static function getAll()
    {
        return self::model()->findAll('id>0 AND deleted=0');
    }

    
    public static function getAllAsArray()
    {
        $sql = "SELECT name,business_name,address,phone,mobile_phone,mail from clients c where deleted = 0 order by name";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public static function create($code,$name, $business_name, $rut, $document, $country, $department, $address, $phone, $mobile_phone, $mail, $second_mail)
    {
        $client = new Clients;
        $client->code = $code == "" ? "-" : $code;
        $client->name = $name == "" ? "-" : $name;
        $client->business_name = $business_name == "" ? "-" : $business_name;
        $client->rut = $rut == "" ? "-" : $rut;
        $client->document = $document == "" ? "-" : $document;
        $client->country = $country == "" ? "-" : $country;
        $client->department = $department == "" ? "-": $department;
        $client->address = $address == "" ? "-" : $address;
        $client->phone = $phone == "" ? "-" : $phone;
        $client->mobile_phone = $mobile_phone == "" ? "-" : $mobile_phone;
        $client->mail = $mail == "" ? "-" : $mail;
        $client->second_mail = $second_mail == "" ? "-" : $second_mail;
        $client->created_on = HelperFunctions::getDate();
        $client->updated_on = HelperFunctions::getDate();
        $client->deleted = 0;
        if ($client->save())
            return $client;
        else {
            Errors::log('Error en Models/Clients/create', 'Error creating client', print_r($client->getErrors(), true));
            return $client;
        }
    }

    public function updateAttributes($code,$name, $business_name, $rut, $document, $country, $department, $address, $phone, $mobile_phone, $mail, $second_mail)
    {
        
        $this->code = $code == "" ? "-" : $code;
        $this->name = $name == "" ? "-" : $name;
        $this->business_name = $business_name == "" ? "-" : $business_name;
        $this->rut = $rut == "" ? "-" : $rut;
        $this->document = $document == "" ? "-" : $document;
        $this->country = $country == "" ? "-" : $country;
        $this->department = $department == "" ? "-": $department;
        $this->address = $address == "" ? "-" : $address;
        $this->phone = $phone == "" ? "-" : $phone;
        $this->mobile_phone = $mobile_phone == "" ? "-" : $mobile_phone;
        $this->mail = $mail == "" ? "-" : $mail;
        $this->second_mail = $second_mail == "" ? "-" : $second_mail;
        $this->updated_on = HelperFunctions::getDate();
        if ($this->save())
            return true;
        else {
            Errors::log('Error en Models/Clients/updateClient', 'Error updating client id:$this->id', print_r($this->getErrors(), true));
            return false;
        }
    }





    public function deleteClient()
    {
        $this->deleted = 1;
        $this->updated_on = HelperFunctions::getDate();
        if ($this->save())
            return true;
        else {
            Errors::log('Error en Models/Clients/deleteClient', 'Error deleting client id:$this->id', print_r($this->getErrors(), true));
            return false;
        }
    }

    public function toArray()
    {
        $me = array();
        $me['id'] = $this->id;
        $me['name'] = $this->name;
        $me['address'] = $this->address;
        $me['phone'] = $this->phone;
        $me['mail'] = $this->mail;
        $me['updated_on'] = $this->updated_on;
        $me['created_on'] = $this->created_on;
        return $me;
    }
}
