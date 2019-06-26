<?php

/**
 * This is the model class for table "work_status_changes".
 *
 * The followings are the available columns in table 'work_status_changes':
 * @property integer $id
 * @property integer $work_id
 * @property integer $original_work_status_id
 * @property integer $final_work_status_id
 * @property string $notes
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 * @property integer $admin_id
 */
 
class WorkStatusChanges extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'WorkStatusChanges';
                case 'singular': return 'WorkStatusChang';
                case 'pluralCamelCase': return 'workStatusChanges';
                case 'singularCamelCase': return 'workStatusChang';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return WorkStatusChanges the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'work_status_changes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_id, original_work_status_id, final_work_status_id, notes, created_on, updated_on, deleted, admin_id, ', 'required'),
                        array('work_id, original_work_status_id, final_work_status_id, admin_id, ', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('id, work_id, original_work_status_id, final_work_status_id, notes, created_on, updated_on, deleted, admin_id, ', 'safe', 'on'=>'search'),
                        
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
                        'original_work_status_id' => 'OriginalWorkStatusId',
                        'final_work_status_id' => 'FinalWorkStatusId',
                        'notes' => 'Notes',
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
                        case 'original_work_status_id': return 'OriginalWorkStatusId';
                        case 'final_work_status_id': return 'FinalWorkStatusId';
                        case 'notes': return 'Notes';
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
                $criteria->compare('original_work_status_id',$this->original_work_status_id);
                $criteria->compare('final_work_status_id',$this->final_work_status_id);
                $criteria->compare('notes',$this->notes,true);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                $criteria->compare('admin_id',$this->admin_id);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $workStatusChang = self::model()->findByPk($id);
            if(isset($workStatusChang->id))
                return $workStatusChang;
            else
                return false;
        }
        
        public static function getAll(){
            return self::model()->findAll('id>0 AND deleted=0');
        }
        
        public static function create($work_id, $original_work_status_id, $final_work_status_id, $notes, $admin_id){
            $workStatusChang = new WorkStatusChanges;
            $workStatusChang->work_id = $work_id;
            $workStatusChang->original_work_status_id = $original_work_status_id;
            $workStatusChang->final_work_status_id = $final_work_status_id;
            $workStatusChang->notes = $notes;
            $workStatusChang->created_on = HelperFunctions::getDate();
            $workStatusChang->updated_on = HelperFunctions::getDate();
            $workStatusChang->deleted = 0;
            $workStatusChang->admin_id = $admin_id;
            if($workStatusChang->save())
                return $workStatusChang;
            else{
                Errors::log('Error en Models/WorkStatusChanges/create','Error creating workStatusChang',print_r($workStatusChang->getErrors(),true));
                return $workStatusChang;
            }
        }
            
        public function updateAttributes($work_id, $original_work_status_id, $final_work_status_id, $notes, $admin_id){
            $this->work_id = $work_id;
            $this->original_work_status_id = $original_work_status_id;
            $this->final_work_status_id = $final_work_status_id;
            $this->notes = $notes;
            $this->updated_on = HelperFunctions::getDate();
            $this->admin_id = $admin_id;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkStatusChanges/updateWorkStatusChang','Error updating workStatusChang id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteWorkStatusChang(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkStatusChanges/deleteWorkStatusChang','Error deleting workStatusChang id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
}
?>