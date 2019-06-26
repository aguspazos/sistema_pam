<?php

/**
 * This is the model class for table "work_finished".
 *
 * The followings are the available columns in table 'work_finished':
 * @property integer $id
 * @property integer $work_id
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 */
 
class WorkFinished extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'WorkFinished';
                case 'singular': return 'WorkFinishe';
                case 'pluralCamelCase': return 'workFinished';
                case 'singularCamelCase': return 'workFinishe';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return WorkFinished the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'work_finished';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_id, created_on, updated_on, deleted, ', 'required'),
                        array('work_id, ', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('id, work_id, created_on, updated_on, deleted, ', 'safe', 'on'=>'search'),
                        
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
                        'work_id' => 'WorkId',
                        'created_on' => 'CreatedOn',
                        'updated_on' => 'UpdatedOn',
                        'deleted' => 'Deleted',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'work_id': return 'WorkId';
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

		$criteria->compare('work_id',$this->work_id);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $workFinishe = self::model()->findByPk($id);
            if(isset($workFinishe->id))
                return $workFinishe;
            else
                return false;
        }
        public static function getFromWorkId($workId){
            $workStatusType = self::model()->find('work_id = :workId and deleted = 0',array('workId'=>$workId));
            if(isset($workStatusType->id))
                return $workStatusType;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($work_id){
            $workFinishe = new WorkFinished;
            $workFinishe->work_id = $work_id;
            $workFinishe->created_on = HelperFunctions::getDate();
            $workFinishe->updated_on = HelperFunctions::getDate();
            $workFinishe->deleted = 0;
            if($workFinishe->save())
                return $workFinishe;
            else{
                Errors::log('Error en Models/WorkFinished/create','Error creating workFinishe',print_r($workFinishe->getErrors(),true));
                return $workFinishe;
            }
        }
            
        public function updateAttributes($work_id){
            $this->work_id = $work_id;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkFinished/updateWorkFinishe','Error updating workFinishe id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteWorkFinishe(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkFinished/deleteWorkFinishe','Error deleting workFinishe id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
        
            
        
            
        
}
?>