<?php

/**
 * This is the model class for table "cookies".
 *
 * The followings are the available columns in table 'cookies':
 * @property integer $id
 * @property string $code
 * @property integer $user_id
 * @property date $created_on
 */
class Cookies extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Cookies the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cookies';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, user_id, created_on', 'required'),
            //array('code, user_id, created_on', 'filter', 'filter'=> array(HelperFunctions, 'purify')),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('created_on', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('code', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, code, user_id, created_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'code',
            'user_id' => 'User',
            'created_on' => 'Created On',
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created_on', $this->created_on);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public static function create() {
        $ip = HelperFunctions::getIP();

        if ($ip != '192.252.218.60') {
            $code = CookieHandler::get('main');

            if (strlen($code) != 32) {
                $code = HelperFunctions::genRandomString(32);
                while (Cookies::model()->exists('code=:code', array('code' => $code)))
                    $code = HelperFunctions::genRandomString(32);
                CookieHandler::set('main', $code);
            }

            $cookie = Cookies::model()->exists('code=:code', array('code' => $code));

            if(!$cookie){
                $cookie = new Cookies;
                $cookie->code = $code;
                $cookie->user_id = 0;

                $user = Users::getCurrent();
                if($user != false)
                    $cookie->user_id = $user->id;

                $cookie->created_on = HelperFunctions::getDate();
                
                $cookie->validate();
                if($cookie->save()){
                    Yii::app()->session['cookieSet'] = '1';
                    return true;
                } 
                else{
                    Errors::log('Error in Models/Cookie/Create', 'Error saving Cookie', 'Errors:' . print_r($cookie->getErrors(), true));
                }
            }
            else{
                $user = Users::getCurrent();
                if ($user!=false) {
                    if ($cookie->user_id != $user->id) {
                        CookieHandler::delete('main');
                        Cookies::create();
                    }
                }
            }
        }
    }

    public static function setUser($user) {
        $cookie = self::getCurrent();
        if ($cookie != false) {
            $cookie->user_id = $user->id;
            
            $cookie->validate();
            if ($cookie->save()) {
                Yii::app()->session['cookieSet'] = '1';
                return true;
            } else
                Errors::log('Error in Models/Cookie/Create', 'Error setting user to Cookie', 'Errors:' . print_r($cookie->getErrors(), true));
        }
        else {
            self::create();
        }
    }

    public static function getCurrent() {
        $ip = HelperFunctions::getIP();

        if ($ip != '192.252.218.60') {
            $code = CookieHandler::get('main');

            if (strlen($code) == 32) {
                $cookie = self::getByCode($code);
                if ($cookie != false) {
                    return $cookie;
                }
            }
        }
        return false;
    }

    public static function getByCode($code) {
        return Cookies::model()->find('code=:code',array('code'=>$code));
    }

    public static function getAll() {
        return self::model()->findAll('id>0');
    }
    
    public static function getAllArray() {
        $mttCookiesArray = array();
        $mttCookies = self::getAll();

        foreach ($mttCookies as $mttCookie) {
            $mttCookiesArray[] = array(
                'id' => $mttCookie->id,
                'user_id' => $mttCookie->user_id,
                'created_on' => $mttCookie->created_on
            );
        }
        return $mttCookiesArray;
    }

}
