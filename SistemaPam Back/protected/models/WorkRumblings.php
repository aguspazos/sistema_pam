<?php

/**
 * This is the model class for table "work_rumblings".
 *
 * The followings are the available columns in table 'work_rumblings':
 * @property integer $id
 * @property integer $work_id
 * @property string $shape
 * @property integer $amount
 * @property string $detail
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 * @property integer $admin_id
 */
 
class WorkRumblings extends CActiveRecord{
    
        
        
        public static function getModelName($type){
            switch($type){
                case 'plural': return 'WorkRumblings';
                case 'singular': return 'WorkRumbling';
                case 'pluralCamelCase': return 'workRumblings';
                case 'singularCamelCase': return 'workRumbling';
                default: return '';
            }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return WorkRumblings the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'work_rumblings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_id, shape, amount, detail, created_on, updated_on, deleted, admin_id, ', 'required'),
                        array('work_id, amount, admin_id, ', 'numerical', 'integerOnly'=>true),
                        array('deleted, ', 'boolean'),
                        array('created_on, updated_on, ', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
                        array('id, work_id, shape, amount, detail, created_on, updated_on, deleted, admin_id, ', 'safe', 'on'=>'search'),
                        
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
                        'shape' => 'Shape',
                        'amount' => 'Amount',
                        'detail' => 'Detail',
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
                        case 'shape': return 'Shape';
                        case 'amount': return 'Amount';
                        case 'detail': return 'Detail';
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
                $criteria->compare('shape',$this->shape);
                $criteria->compare('amount',$this->amount);
                $criteria->compare('detail',$this->detail,true);
                $criteria->compare('created_on',$this->created_on);
                $criteria->compare('updated_on',$this->updated_on);
                $criteria->compare('deleted',$this->deleted);
                $criteria->compare('admin_id',$this->admin_id);
                

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public static function get($id){
            $workRumbling = self::model()->findByPk($id);
            if(isset($workRumbling->id))
                return $workRumbling;
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
        
        public static function create($work_id, $shape, $amount, $detail, $admin_id){
            $workRumbling = new WorkRumblings;
            $workRumbling->work_id = $work_id;
            $workRumbling->shape = $shape;
            $workRumbling->amount = $amount;
            $workRumbling->detail = $detail;
            $workRumbling->created_on = HelperFunctions::getDate();
            $workRumbling->updated_on = HelperFunctions::getDate();
            $workRumbling->deleted = 0;
            $workRumbling->admin_id = $admin_id;
            if($workRumbling->save())
                return $workRumbling;
            else{
                Errors::log('Error en Models/WorkRumblings/create','Error creating workRumbling',print_r($workRumbling->getErrors(),true));
                return $workRumbling;
            }
        }
            
        public function updateAttributes($work_id, $shape, $amount, $detail, $admin_id){
            $this->work_id = $work_id;
            $this->shape = $shape;
            $this->amount = $amount;
            $this->detail = $detail;
            $this->updated_on = HelperFunctions::getDate();
            $this->admin_id = $admin_id;
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkRumblings/updateWorkRumbling','Error updating workRumbling id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }
            
        
            
        
            
        public function deleteWorkRumbling(){
            $this->deleted = 1;
            $this->updated_on = HelperFunctions::getDate();
            if($this->save())
                return true;
            else{
                Errors::log('Error en Models/WorkRumblings/deleteWorkRumbling','Error deleting workRumbling id:$this->id', print_r($this->getErrors(),true));
                return false;
            }
        }

        public function toArray($withNotes = false){
            $me = array();
            $me['shape'] = $this->shape;
            $me['amount'] = $this->amount;
            $me['detail'] = $this->detail;
            if($withNotes){
                $workStatusChanges = WorkStatusChanges::getAllFromWorkAndFinalStatus($this->work_id,WorkStatuses::$WITH_RUMBLING);
                foreach($workStatusChanges as $workStatusChange){
                    $me['notes'][] = $workStatusChange->notes;
                }
            }
            return $me;
        }
            
        
            
        
}
?>