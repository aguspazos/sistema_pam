<?php

/**
 * This is the model class for table "work_details".
 *
 * The followings are the available columns in table 'work_details':
 * @property integer $id
 * @property integer $work_id
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 * @property integer $admin_id
 */
 
class WorkDetails extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'WorkDetails';
                case 'singular': return 'WorkDetail';
                case 'pluralCamelCase': return 'workDetails';
                case 'singularCamelCase': return 'workDetail';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return WorkDetails the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'work_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_id, created_on, updated_on, deleted, admin_id, ', 'required'),
                        array('work_id, admin_id, ', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('id, work_id, created_on, updated_on, deleted, admin_id, ', 'safe', 'on'=>'search'),
                        
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
                        'admin_id' => 'AdminId',
                        
		);
	}
        
        
	public static function getAttributeName($name){
            switch($name){
                case 'id': return 'ID';
                        case 'work_id': return 'WorkId';
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
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                $criteria->compare('admin_id',$this->admin_id);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $workDetail = self::model()->findByPk($id);
            if(isset($workDetail->id))
                return $workDetail;
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
        
        
        public static function create($work_id, $admin_id){
            $workDetail = new WorkDetails;
            $workDetail->work_id = $work_id;
            $workDetail->created_on = HelperFunctions::getDate();
            $workDetail->updated_on = HelperFunctions::getDate();
            $workDetail->deleted = 0;
            $workDetail->admin_id = $admin_id;
            if($workDetail->save())
                return $workDetail;
            else{
                Errors::log('Error en Models/WorkDetails/create','Error creating workDetail',print_r($workDetail->getErrors(),true));
                return $workDetail;
            }
        }
            
        public function updateAttributes($work_id, $admin_id){
            $this->work_id = $work_id;
            $this->updated_on = HelperFunctions::getDate();
            $this->admin_id = $admin_id;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkDetails/updateWorkDetail','Error updating workDetail id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteWorkDetail(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkDetails/deleteWorkDetail','Error deleting workDetail id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
}
?>