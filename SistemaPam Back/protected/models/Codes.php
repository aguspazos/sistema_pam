<?php

/**
 * This is the model class for table "codes".
 *
 * The followings are the available columns in table 'codes':
 * @property integer $id
 * @property string $code
 * @property boolean $old_code
 * @property string $used
 * @property datetime $created_on
 * @property string $used_on
 */
 
class Codes extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'Codes';
                case 'singular': return 'Cod';
                case 'pluralCamelCase': return 'codes';
                case 'singularCamelCase': return 'cod';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Codes the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, old_code, used, created_on, used_on, ', 'required'),
                        array('old_code, ', 'boolean'),
                        array('created_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('code', 'length', 'max'=>32),
                        array('used', 'length', 'max'=>4),
                        array('id, code, old_code, used, created_on, used_on, ', 'safe', 'on'=>'search'),
                        
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
                        'code' => 'Code',
                        'old_code' => 'OldCode',
                        'used' => 'Used',
                        'created_on' => 'CreatedOn',
                        'used_on' => 'UsedOn',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'code': return 'Code';
                        case 'old_code': return 'OldCode';
                        case 'used': return 'Used';
                        case 'created_on': return 'CreatedOn';
                        case 'used_on': return 'UsedOn';
                        
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

		$criteria->compare('code',$this->code,true);
                $criteria->compare('old_code',$this->old_code);
                $criteria->compare('used',$this->used,true);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('used_on',$this->used_on,true);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $cod = self::model()->findByPk($id);
            if(isset($cod->id))
                return $cod;
            else
                return false;
        }
        
        public static function getByCode($code){
            $cod = self::model()->find('code=:code',array('code'=>$code));
            if(isset($cod->id))
                return $cod;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0');
        }
        
        public static function create($code, $old_code){
            $cod = new Codes;
            $cod->code = $code;
            $cod->old_code = $old_code;
            $cod->used = 0;
            $cod->created_on = HelperFunctions::getDate();
            $cod->used_on = '1900-01-01 00:00:00';
            if($cod->save())
                return $cod;
            else{
                Errors::log('Error en Models/Codes/create','Error creating cod',print_r($cod->getErrors(),true));
                return $cod;
            }
        }
            
        public function updateAttributes($code, $old_code){
            $this->code = $code;
            $this->old_code = $old_code;
            $this->used = '0';
            $this->used_on = '1900-01-01 00:00:00';
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Codes/updateCod','Error updating cod id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        public function useCode(){
            $this->used = '1';
            $this->used_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/Codes/useCode','Error useCode cod id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        public function deleteCod(){
                if($this->delete())
                    return true;
                else{
                    Errors::log('Error en Models/Codes/deleteCod','Error deleting cod id:$this->id', print_r($this->getErrors(),true));
                    return false;
                }
            }
            
        
            
        
}
?>