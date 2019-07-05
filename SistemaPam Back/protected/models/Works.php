<?php

/**
 * This is the model class for table "works".
 *
 * The followings are the available columns in table 'works':
 * @property integer $id
 * @property integer $print_type_id
 * @property string $paper_size
 * @property string $paper_type_id
 * @property integer $prints_amount
 * @property string $image_url
 * @property string $notes
 * @property datetime $created_on
 * @property datetime $updated_on
 * @property boolean $deleted
 * @property integer $admin_id
 * @property integer $current_work_status_id
 * @property integer $current_status_type_id
 * @property  datetime $due_date
 */

class Works extends CActiveRecord
{



    public static function getModelName($type)
    {
        switch ($type) {
            case 'plural':
                return 'Works';
            case 'singular':
                return 'Work';
            case 'pluralCamelCase':
                return 'works';
            case 'singularCamelCase':
                return 'work';
            default:
                return '';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Works the static model class
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
        return 'works';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('print_type_id, paper_size, paper_type_id, prints_amount, image_url, notes, created_on, updated_on, deleted, admin_id, current_work_status_id, current_status_type_id,due_date, ', 'required'),
            array('print_type_id, prints_amount, admin_id, current_work_status_id, current_status_type_id, ', 'numerical', 'integerOnly' => true),
            array('deleted, ', 'boolean'),
            array('created_on, updated_on, ', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'),
            array('image_url', 'length', 'max' => 512),
            array('id, print_type_id, paper_size, paper_type_id, prints_amount, image_url, notes, created_on, updated_on, deleted, admin_id, current_work_status_id, current_status_type_id, ', 'safe', 'on' => 'search'),

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
            'print_type_id' => 'PrintTypeId',
            'paper_size' => 'PaperSize',
            'paper_type_id' => 'PaperTypeId',
            'prints_amount' => 'PrintsAmount',
            'image_url' => 'ImageUrl',
            'notes' => 'Notes',
            'created_on' => 'CreatedOn',
            'updated_on' => 'UpdatedOn',
            'deleted' => 'Deleted',
            'admin_id' => 'AdminId',
            'current_work_status_id' => 'CurrentWorkStatusId',
            'current_status_type_id' => 'CurrentStatusTypeId',

        );
    }


    public static function getAttributeName($name)
    {
        switch ($name) {
            case 'id':
                return 'ID';
            case 'print_type_id':
                return 'PrintTypeId';
            case 'paper_size':
                return 'PaperSize';
            case 'paper_type_id':
                return 'PaperTypeId';
            case 'prints_amount':
                return 'PrintsAmount';
            case 'image_url':
                return 'ImageUrl';
            case 'notes':
                return 'Notes';
            case 'created_on':
                return 'CreatedOn';
            case 'updated_on':
                return 'UpdatedOn';
            case 'deleted':
                return 'Deleted';
            case 'admin_id':
                return 'AdminId';
            case 'current_work_status_id':
                return 'CurrentWorkStatusId';
            case 'current_status_type_id':
                return 'CurrentStatusTypeId';

            default:
                return '';
        }
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

        $criteria->compare('print_type_id', $this->print_type_id);
        $criteria->compare('paper_size', $this->paper_size);
        $criteria->compare('paper_type_id', $this->paper_type_id, true);
        $criteria->compare('prints_amount', $this->prints_amount);
        $criteria->compare('image_url', $this->image_url, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('created_on', $this->created_on);
        $criteria->compare('updated_on', $this->updated_on);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('current_work_status_id', $this->current_work_status_id);
        $criteria->compare('current_status_type_id', $this->current_status_type_id);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public static function get($id)
    {
        $work = self::model()->findByPk($id);
        if (isset($work->id))
            return $work;
        else
            return false;
    }

    public static function getAll()
    {
        return self::model()->findAll('id>0 AND deleted=0');
    }

    public static function getAllNotFinished($adminId = 0)
    {
        $allWorks = Works::getAll();
        $worksToReturn = array();
        foreach ($allWorks as $work){
            $nextStatus = $work->retrieveNextStatus($work->current_work_status_id + 1);
            $nextStatusId = $nextStatus['current_work_status_id'];
            $nextStatusName = WorkStatuses::getName($nextStatusId);
            if($nextStatusName != "Para Entregar" && $nextStatusName != "Entregado"){
                $worksToReturn[] = $work;
            }
        }
        return $worksToReturn; //self::model()->findAll('current_work_status_id < :status and deleted = 0 order by due_date ASC', array('status' => WorkStatuses::$BOUNDED));
    }

    
    public static function getAllToSend($adminId = 0)
    {
        $allWorks = Works::getAll();
        $worksToReturn = array();
        foreach ($allWorks as $work){
            $nextStatus = $work->retrieveNextStatus($work->current_work_status_id + 1);
            $nextStatusId = $nextStatus['current_work_status_id'];
            $nextStatusName = WorkStatuses::getName($nextStatusId);
            if($nextStatusName == "Para Entregar"){
                $worksToReturn[] = $work;
            }
        }
        return $worksToReturn;
       // return self::model()->findAll('current_work_status_id = :status and deleted = 0 order by due_date ASC', array('status' => WorkStatuses::$BOUNDED));
    }
    public static function getAllSent($adminId = 0)
    {
        $allWorks = Works::getAll();
        $worksToReturn = array();
        foreach ($allWorks as $work){
            $nextStatus = $work->retrieveNextStatus($work->current_work_status_id + 1);
            $nextStatusId = $nextStatus['current_work_status_id'];
            $nextStatusName = WorkStatuses::getName($nextStatusId);
            if($nextStatusName == "Entregado"){
                $worksToReturn[] = $work;
            }
        }
        return $worksToReturn;
     //   return self::model()->findAll('current_work_status_id = :status and deleted = 0 order by due_date ASC', array('status' => WorkStatuses::$FINISHED));
    }
    public static function create($print_type_id, $paper_size, $paper_type_id, $prints_amount, $image_url, $notes, $admin_id, $current_work_status_id, $current_status_type_id,$due_date)
    {
        $work = new Works;
        $work->print_type_id = $print_type_id;
        $work->paper_size = $paper_size;
        $work->paper_type_id = $paper_type_id;
        $work->prints_amount = $prints_amount;
        $work->image_url = $image_url;
        $work->notes = $notes;
        $work->created_on = HelperFunctions::getDate();
        $work->updated_on = HelperFunctions::getDate();
        $work->deleted = 0;
        $work->admin_id = $admin_id;
        $work->current_work_status_id = $current_work_status_id;
        $work->current_status_type_id = $current_status_type_id;
        $work->due_date = HelperFunctions::getFormattedDate($due_date);
        if ($work->save())
            return $work;
        else {
            Errors::log('Error en Models/Works/create', 'Error creating work', print_r($work->getErrors(), true));
            return $work;
        }
    }

    public function updateAttributes($print_type_id, $paper_size, $paper_type_id, $prints_amount, $image_url, $notes, $admin_id,$due_date)
    {
        $this->print_type_id = $print_type_id;
        $this->paper_size = $paper_size;
        $this->paper_type_id = $paper_type_id;
        $this->prints_amount = $prints_amount;
        $this->image_url = $image_url;
        $this->notes = $notes;
        $this->updated_on = HelperFunctions::getDate();
        $this->admin_id = $admin_id;
        $this->due_date =getFormattedDate($due_date);
        if ($this->save())
            return true;
        else {
            Errors::log('Error en Models/Works/updateWork', 'Error updating work id:$this->id', print_r($this->getErrors(), true));
            return false;
        }
    }





    public function deleteWork()
    {
        $this->deleted = 1;
        $this->updated_on = HelperFunctions::getDate();
        if ($this->save())
            return true;
        else {
            Errors::log('Error en Models/Works/deleteWork', 'Error deleting work id:$this->id', print_r($this->getErrors(), true));
            return false;
        }
    }

    public function getLaminatedData()
    {
        $workLaminate = WorkLaminates::get($this->current_status_type_id);
        if ($workLaminate) {
            return $workLaminate->toArray();
        } else {
            return array();
        }
    }

    public function getRumbledData()
    {
        $workRumblings = WorkRumblings::get($this->current_status_type_id);
        if ($workRumblings) {
            return $workRumblings->toArray();
        } else {
            return array();
        }
    }

    public function getBoundedData()
    {
        $workBound = WorkBounds::get($this->current_status_type_id);
        if ($workBound) {
            return $workBound->toArray();
        } else {
            return array();
        }
    }

    public function nextStatus($notes,$adminId)
    {
        $response  = array();
        $nextStatus = $this->retrieveNextStatus($this->current_work_status_id + 1);
        $originalStatusId = $this->current_status_type_id;
        $this->current_status_type_id = $nextStatus['current_status_type_id'];
        $this->current_work_status_id = $nextStatus['current_work_status_id'];
        $this->updated_on = HelperFunctions::getDate();
        if ($this->save()) {
            WorkStatusChanges::create($this->id,$originalStatusId,$this->current_work_status_id,$notes,$adminId);
            $response['status'] = 'ok';
            $response['message'] = 'Estado Actualizado';
            $response['currentStatus'] = $this->current_work_status_id;
            $nextStatus = $this->retrieveNextStatus($this->current_work_status_id + 1);
            $nextStatusId = $nextStatus['current_work_status_id'];
            $nextStatusName = WorkStatuses::getName($nextStatusId);
            if($nextStatusName == "Para Entregar"){
                $deliver = WorkDelivers::getFromWorkId($this->id);
                if($deliver != false){
                    $client = Clients::get($deliver->client_id);
                    if($client != false){
                      //  Works::sendMail("Trabajo Pronto", "Le informamos que su trabajo está pronto","Le informamos que su trabajo está pronto",$client->mail,$client->name);
                    }
                }

            }
            if($nextStatusName == "Entregado"){
                $deliver = WorkDelivers::getFromWorkId($this->id);
                if($deliver != false){
                    $client = Clients::get($deliver->client_id);
                    if($client != false){
                      //  Works::sendMail("Trabajo Entregado", "Le informamos que entregamos su trabajo","Le informamos que entregamos su trabajo",$client->mail,$client->name);
                    }
                }

            }
            $response['next_status_name'] = $nextStatusName;
        } else {
            $response['status'] = 'error';
            $response['message'] = print_r(HelperFunctions::getErrorsFromModel($this), true);
        }
        return $response;
    }

    public function retrieveNextStatus($currentWorkStatus)
    {

        if($currentWorkStatus >= WorkStatuses::$DELIVERED){
            $workDelivered = WorkDelivers::getFromWorkId($this->id);
            if ($workDelivered) {
                return array('current_status_type_id' => $workDelivered->id, 'current_work_status_id' => WorkStatuses::$DELIVERED);
            } else {
                return array('current_status_type_id' => $this->current_status_type_id, 'current_work_status_id' => $this->current_work_status_id);
            }
        }
        if ($currentWorkStatus == WorkStatuses::$FINISHED) {
            $workFinish = WorkFinished::getFromWorkId($this->id);
            if ($workFinish) {
                return array('current_status_type_id' => $workFinish->id, 'current_work_status_id' => WorkStatuses::$FINISHED);
            } else {
                return array('current_status_type_id' => 0, 'current_work_status_id' => WorkStatuses::$FINISHED);
            }
        } else {
            $currentStatusType = $this->getCurrentStatusType($currentWorkStatus);
            if ($currentStatusType) {
                return array('current_status_type_id' => $currentStatusType->id, 'current_work_status_id' => $currentWorkStatus);
            } else {
                return $this->retrieveNextStatus($currentWorkStatus + 1);
            }
        }
    }


    public function getCurrentStatusType($currentWorkStatus)
    {
        switch ($currentWorkStatus) {
            case WorkStatuses::$PRINTED:
                return WorkPrints::getFromWorkId($this->id);
                break;
            case WorkStatuses::$WITH_LAMINATE:
                return WorkLaminates::getFromWorkId($this->id);
                break;
            case WorkStatuses::$WITH_RUMBLING:
                return WorkRumblings::getFromWorkId($this->id);
                break;
            case WorkStatuses::$WITH_UV:
                return WorkUvs::getFromWorkId($this->id);
                break;
            case WorkStatuses::$BOUNDED:
                return WorkBounds::getFromWorkId($this->id);
                break;
        }
    }

    public static function sendMail($subject,$nonHtmlBody,$htmlBody,$destinationMail, $destinationName)
    {

        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;
        $mail->Username = 'matigru@gmail.com';                 // SMTP username
        $mail->Password = 'Size45661794';                        // Enable SMTP authentication                       // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

        $mail->From = 'matigru@gmail.com';
        $mail->FromName = 'PAM';

        $mail->addAddress($destinationMail, $destinationName);

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;//'Here is the subject';
        $mail->Body    = $htmlBody;//'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = $nonHtmlBody;//'This is the body in plain texst for non-HTML mail clients';

        if (!$mail->send()) {
            Errors::log("No se pudo mandar el mail","Hola");
        }
    }

    public function toArray($withStatusTypes = false,$withNotes = true){
        $me = array();
        $me['id'] = $this->id;
        $me['print_type_id'] = $this->print_type_id;
        $me['paper_size'] = $this->paper_size;
        $me['prints_amount'] = $this->prints_amount;
        $me['paper_type_id'] = $this->paper_type_id;
        $me['image_url'] = $this->image_url;
        $me['notes'] = $this->notes;
        $me['created_on'] = $this->created_on;
        $me['updated_on'] = $this->updated_on;
        $me['deleted'] = $this->deleted;
        $me['due_date'] = $this->due_date;
        $me['admin_id'] = $this->admin_id;
        $me['current_work_status_id'] = $this->current_work_status_id;
        $nextStatus = $this->retrieveNextStatus($this->current_work_status_id + 1);
        $nextStatusId = $nextStatus['current_work_status_id'];
        $nextStatusName = WorkStatuses::getName($nextStatusId);
        $me['next_status_name'] = $nextStatusName;
        $me['current_status_type_id'] = $this->current_status_type_id;
        $deliver = WorkDelivers::getFromWorkId($this->id);
        if($deliver != false){
            $client = Clients::get($deliver->client_id);
            if($client != false){
                $me['client'] = $client->toArray();
            }else{
                $me['client']['name'] = "Sin Cliente";
            }

        }else{
            $me['client']['name'] = "Sin Cliente";

        }
        if($withStatusTypes){
            $laminated = 'noData';
            $workLaminated = WorkLaminates::getFromWorkId($this->id);
            if($workLaminated){
                $laminated = $workLaminated->toArray(true);
            }
            $me['work_laminates'] = $laminated;


            $rumbled = 'noData';
            $workRumbled = WorkRumblings::getFromWorkId($this->id);
            if($workRumbled){
                $rumbled = $workRumbled->toArray($withNotes);
            }
            $me['work_rumblings'] = $rumbled;

            $bounded = 'noData';
            $workBound = WorkBounds::getFromWorkId($this->id);
            if($workBound){
                $bounded = $workBound->toArray($withNotes);
            }
            $me['work_bounds'] = $bounded;

            $uv = 'noData';
            $workUv = WorkUvs::getFromWorkId($this->id);
            if($workUv){
                $uv = $workUv->toArray($withNotes);
            }
            $me['work_uvs'] = $uv;
        }
        
        return $me;
    }
}
