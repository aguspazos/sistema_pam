<?php

/**
 * This is the model class for table "work_laminates".
 *
 * The followings are the available columns in table 'work_laminates':
 * @property integer $id
 * @property integer $work_id
 * @property string $printing
 * @property integer $type
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 * @property integer $admin_id
 * @property string $notes
 */
 
class WorkLaminates extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'WorkLaminates';
                case 'singular': return 'WorkLaminat';
                case 'pluralCamelCase': return 'workLaminates';
                case 'singularCamelCase': return 'workLaminat';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return WorkLaminates the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'work_laminates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_id, printing, type, created_on, updated_on, deleted, admin_id, ', 'required'),
                        array('work_id, type, admin_id, ', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('id, work_id, printing, type, created_on, updated_on, deleted, admin_id, ', 'safe', 'on'=>'search'),
                        
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
                        'printing' => 'Printing',
                        'type' => 'Type',
                        'created_on' => 'CreatedOn',
                        'updated_on' => 'UpdatedOn',
                        'deleted' => 'Deleted',
                        'admin_id' => 'AdminId',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'work_id': return 'WorkId';
                        case 'printing': return 'Printing';
                        case 'type': return 'Type';
                        case 'created_on': return 'CreatedOn';
                        case 'updated_on': return 'UpdatedOn';
                        case 'deleted': return 'Deleted';
                        case 'admin_id': return 'AdminId';
                        
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
                $criteria->compare('printing',$this->printing);
                $criteria->compare('type',$this->type);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                $criteria->compare('admin_id',$this->admin_id);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $workLaminat = self::model()->findByPk($id);
            if(isset($workLaminat->id))
                return $workLaminat;
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
        
        public static function create($work_id, $printing, $type,$notes, $admin_id){
            $workLaminat = new WorkLaminates;
            $workLaminat->work_id = $work_id;
            $workLaminat->printing = $printing;
            $workLaminat->type = $type;
            $workLaminat->notes = $notes;
            $workLaminat->created_on = HelperFunctions::getDate();
            $workLaminat->updated_on = HelperFunctions::getDate();
            $workLaminat->deleted = 0;
            $workLaminat->admin_id = $admin_id;
            if($workLaminat->save())
                return $workLaminat;
            else{
                Errors::log('Error en Models/WorkLaminates/create','Error creating workLaminat',print_r($workLaminat->getErrors(),true));
                return $workLaminat;
            }
        }
            
        public function updateAttributes($work_id, $printing, $type,$notes, $admin_id){
            $this->work_id = $work_id;
            $this->printing = $printing;
            $this->type = $type;
            $this->notes = $notes;
            $this->updated_on = HelperFunctions::getDate();
            $this->admin_id = $admin_id;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkLaminates/updateWorkLaminat','Error updating workLaminat id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteWorkLaminat(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkLaminates/deleteWorkLaminat','Error deleting workLaminat id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }

        public function toArray($withNotes = false){
            $me = array();
            $me['printing'] = $this->printing;
            $me['notes'] = $this->notes;
            $me['type'] = $this->type;

            if($withNotes){
                $workStatusChanges = WorkStatusChanges::getAllFromWorkAndFinalStatus($this->work_id,WorkStatuses::$WITH_LAMINATE);
                foreach($workStatusChanges as $workStatusChange){
                    $me['notes'][] = $workStatusChange->notes;
                }
            }
            return $me;
        }
            
        
            
        
}
?>