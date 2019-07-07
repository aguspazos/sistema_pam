<?php

/**
 * This is the model class for table "work_bounds".
 *
 * The followings are the available columns in table 'work_bounds':
 * @property integer $id
 * @property integer $work_id
 * @property integer $type
 * @property string $others_text
 * @property string $notes
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 * @property integer $admin_id
 */
 
class WorkBounds extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'WorkBounds';
                case 'singular': return 'WorkBound';
                case 'pluralCamelCase': return 'workBounds';
                case 'singularCamelCase': return 'workBound';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return WorkBounds the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'work_bounds';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_id, type, others_text, created_on, updated_on, deleted, admin_id, ', 'required'),
                        array('work_id, type, admin_id, ', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('id, work_id, type, others_text, created_on, updated_on, deleted, admin_id, ', 'safe', 'on'=>'search'),
                        
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
                        'type' => 'Type',
                        'others_text' => 'OthersText',
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
                        case 'type': return 'Type';
                        case 'others_text': return 'OthersText';
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
                $criteria->compare('type',$this->type);
                $criteria->compare('others_text',$this->others_text,true);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                $criteria->compare('admin_id',$this->admin_id);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $workBound = self::model()->findByPk($id);
            if(isset($workBound->id))
                return $workBound;
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
        
        public static function create($work_id, $type, $others_text,$notes, $admin_id){
            $workBound = new WorkBounds;
            $workBound->work_id = $work_id;
            $workBound->type = $type;
            $workBound->others_text = $others_text;
            $workBound->notes = $notes;
            $workBound->created_on = HelperFunctions::getDate();
            $workBound->updated_on = HelperFunctions::getDate();
            $workBound->deleted = 0;
            $workBound->admin_id = $admin_id;
            if($workBound->save())
                return $workBound;
            else{
                Errors::log('Error en Models/WorkBounds/create','Error creating workBound',print_r($workBound->getErrors(),true));
                return $workBound;
            }
        }
            
        public function updateAttributes($work_id, $type, $others_text,$notes, $admin_id){
            $this->work_id = $work_id;
            $this->type = $type;
            $this->others_text = $others_text;
            $this->notes = $notes;
            $this->updated_on = HelperFunctions::getDate();
            $this->admin_id = $admin_id;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkBounds/updateWorkBound','Error updating workBound id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteWorkBound(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkBounds/deleteWorkBound','Error deleting workBound id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }

        public function toArray($withNotes = false){
            $me = array();
            $me['type'] = $this->type;
            $me['others_text'] = $this->others_text;
            $me['notes'] = $this->notes;
            if($withNotes){
                $workStatusChanges = WorkStatusChanges::getAllFromWorkAndFinalStatus($this->work_id,WorkStatuses::$BOUNDED);
                foreach($workStatusChanges as $workStatusChange){
                    $me['notes'][] = $workStatusChange->notes;
                }
            }
            return $me;
        }
            
        
            
        
}
?>