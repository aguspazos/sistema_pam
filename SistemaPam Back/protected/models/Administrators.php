<?php

/**
 * This is the model class for table "administrators".
 *
 * The followings are the available columns in table 'administrators':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $last_name
 * @property string $phone
 * @property boolean $active
 * @property boolean $deleted
 * @property datetime $last_password_change
 */

class Administrators extends CActiveRecord
{

    public $administratorFiles;
    /**
     * Returns the static model of the specified AR class.
     * @return Administrators the static model class
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
        return 'administrators';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password, name, last_name, phone, administrator_role_id, active, deleted, ', 'required'),
            //array('email, password, name, last_name, phone, administrator_role_id, active, deleted, ', 'filter', 'filter'=> array(HelperFunctions, 'purify')),
            array('active, deleted, ', 'boolean'),
            array('email', 'length', 'max' => 64),
            array('password', 'length', 'max' => 64),
            array('name', 'length', 'max' => 32),
            array('last_name', 'length', 'max' => 32),
            array('phone', 'length', 'max' => 16),
            array('last_password_change', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('id, email, password, name, last_name, phone, administrator_role_id, active, deleted, ', 'safe', 'on' => 'search'),

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
            'email' => 'Email',
            'password' => 'Password',
            'name' => 'Name',
            'last_name' => 'LastName',
            'phone' => 'Phone',
            'administrator_role_id' => 'AdministratorRoleId',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'last_password_change' => 'last_password_change',

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

        $criteria = new CDbCriteria;

        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('administrator_role_id', $this->administrator_role_id);
        $criteria->compare('active', $this->active);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('last_password_change', $this->last_password_change);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public static function get($id)
    {
        $administrator = Administrators::model()->findByPk($id);
        if (isset($administrator->id))
            return $administrator;
        else
            return false;
    }

    public static function getByEmail($email)
    {
        $administrator = Administrators::model()->find('email=:email', array('email' => $email));
        if (isset($administrator->id))
            return $administrator;
        else
            return false;
    }

    public static function getCurrentAdministrator()
    {
        if (isset($_POST['token'])) {
            $administrator = Administrators::model()->find('token = :token', array('token' => $_POST['token']));
            if (isset($administrator->id))
                return $administrator;
            return false;
        } else {
            return false;
        }
        // if(isset(Yii::app()->session['session_admin_id'])){
        //     $id = Yii::app()->session['session_admin_id'];
        //     $administrator = Administrators::model()->findByPk($id);
        //     if(isset($administrator->id))
        //         return $administrator;
        //     else
        //         return false;
        // }
        // else
        //     return false;
    }

    public static function getAll()
    {
        return Administrators::model()->findAll('deleted=0');
    }

    public static function create($email, $name, $last_name, $phone, $administrator_role_id, $active,$password)
    {
        $administrator = new Administrators;
        $administrator->email = $email;
        $administrator->password = crypt(md5($password), Yii::app()->params['salt']);
        $administrator->name = $name;
        $administrator->last_name = $last_name;
        $administrator->phone = $phone;
        $administrator->administrator_role_id = $administrator_role_id;
        $administrator->active = $active;
        $administrator->deleted = 0;
        $administrator->last_password_change = '1900-01-01 00:00:00';
        $administrator->token = "";

        $administrator->validate();
        if ($administrator->save()) {
            //EmailHelper::sendNewAdministrator($administrator->email, $administrator->name . ' ' . $administrator->last_name, $administrator->email, $password);
            return $administrator;
        } else {
            Errors::log('Error en Models/Administrators/create', 'Error creating administrator', print_r($administrator->getErrors(), true));
            return $administrator;
        }
    }

    public function updateAttributes($email, $name, $last_name, $phone, $administrator_role_id, $active)
    {
        $this->email = $email;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->phone = $phone;
        $this->administrator_role_id = $administrator_role_id;
        $this->active = $active;

        $this->validate();
        if ($this->save())
            return true;
        else {
            Errors::log('Error en Models/Administrators/updateAdministrator', 'Error updating administrator id:$this->id', print_r($this->getErrors(), true));
            return false;
        }
    }

    public static function checkUnique($email, $id = 0)
    {
        $administrators = Administrators::model()->findAll("email=:emailVar", array('emailVar' => $email));
        if (count($administrators) > 1)
            return false;
        else if (count($administrators) == 1 && $administrators[0]->id != $id)
            return false;
        return true;
    }

    public function deleteAdministrator()
    {
        $this->deleted = 1;

        $this->validate();
        if ($this->save())
            return true;
        else {
            Errors::log('Error en Models/Administrators/deleteAdministrator', 'Error deleting administrator id:$this->id', print_r($this->getErrors(), true));
            return $this;
        }
    }

    public function loadAdministratorFiles()
    {
        $this->administratorFiles = array();
        $administratorFiles = AdministratorFiles::model()->findAll('administrator_id=:administratorId AND deleted=0 ORDER BY position ASC', array('administratorId' => $this->id));
        foreach ($administratorFiles as $administratorFile) {
            $file = Files::get($administratorFile->file_id);
            if ($file !== false)
                $this->administratorFiles[] = $file;
        }
    }


    public function getAllFromAdministratorRole($administratorRoleId)
    {
        return Administrators::model()->findAll('administrator_role_id=:administratorRoleIdVar AND deleted=0', array('administratorRoleIdVar' => $administratorRoleId));
    }

    public function changePassword($oldPassword, $newPassword, $newPasswordRepeat)
    {
        if (strlen($newPassword) < 20 && strlen($newPassword) > 5) {
            if ($newPassword === $newPasswordRepeat) {
                if ($oldPassword != $newPassword) {
                    if (crypt(md5($oldPassword), Yii::app()->params['salt']) === $this->password) {
                        $this->password = crypt(md5($newPassword), Yii::app()->params['salt']);
                        $this->last_password_change = HelperFunctions::getDate();
                        $this->validate();
                        return $this->save();
                    }
                }
            }
        }
        return false;
    }

    public function resetPassword()
    {
        $password = HelperFunctions::genRandomPassword();
        $this->password = crypt(md5($password), Yii::app()->params['salt']);
        $this->last_password_change = '1900-01-01 00:00:00';

        $this->validate();
        if ($this->save()) {
            //EmailHelper::sendNewClientUser($this->email, $this->name . ' ' . $this->last_name, $this->email, $password);
        } else {
            Errors::log('Error en Models/Administrators/resetPassword', 'Error resetting administrator password', print_r($this->getErrors(), true));
        }
    }

    public function refreshToken(){
        $this->token = HelperFunctions::genRandomCode(32);
        if ($this->save()) {
            //EmailHelper::sendNewClientUser($this->email, $this->name . ' ' . $this->last_name, $this->email, $password);
        } else {
            Errors::log('Error en Models/Administrators/resetPassword', 'Error resetting administrator password', print_r($this->getErrors(), true));
        }
    }
}
