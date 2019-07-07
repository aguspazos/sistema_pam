<?php

/**
 * This is the model class for table "logs".
 *
 * The followings are the available columns in table 'logs':
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $aux
 * @property string $aux_2
 * @property boolean active
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 */
class Preferences extends CActiveRecord
{

    private static $AMAZON_KEY_NAME = "amazon_key";
    private static $AMAZON_SECRET_NAME = "amazon_secret";
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'preferences';
    }


    public static function getAmazonKeyAndSecret()
    {
        $data = array();
        $key = self::model()->find('name = :amazon_key',array('amazon_key'=>self::$AMAZON_KEY_NAME));
        if(isset($key->id)){
            $data['amazon_key'] = $key->value;
        }
        $secret = self::model()->find('name = :amazon_secret',array('amazon_secret'=>self::$AMAZON_SECRET_NAME));
        if(isset($secret->id)){
            $data['amazon_secret'] = $secret->value;
        }
        return $data;
    }
}
