<?php
    
    class ContactMessagesController extends Controller{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules(){
		return array(
			
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('send'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('getArray','getAllArray','viewMain','viewAdd','viewEdit','add','save','delete'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->role) && (Yii::app()->user->role===\'admin\')',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewMain(){
		try
		{
                    
                    $this->render('main');
		}
		catch (Exception $ex)
		{
			Errors::log('Error en ContactMessagesController/actionViewMain',$ex->getMessage(),'');
			$this->redirect('/site/userError');
		}
	}
        
        public function actionGetArray(){
            try{
                if(isset($_POST['id']) && is_numeric($_POST['id'])){
                    $contactMessag = ContactMessages::get($_POST['id']);
                    if(isset($contactMessag->id)){
                        $contactMessagArray = HelperFunctions::modelToArray($contactMessag);
                        
                        
                        
                        $response['status'] = 'ok';
                        $response['contactMessag'] = $contactMessagArray;
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'NoContactMessagWithId';
                        $response['errorMessage'] = 'NoContactMessagWithId';
                    }
                }
                else{
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en ContactMessagesController/actionGetArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
        public function actionGetAllArray(){
            try{
                $contactMessagesArray = array();
                $contactMessages = ContactMessages::getAll();
                foreach($contactMessages as $contactMessag)
                    $contactMessagesArray[] = HelperFunctions::modelToArray($contactMessag);
                
                $response['contactMessages'] = $contactMessagesArray;
                $response['status'] = 'ok';
                
                echo json_encode($response);
            }
            catch (Exception $ex){
                Errors::log('Error en ContactMessagesController/actionGetAllArray',$ex->getMessage(),'');
                $response['status'] = 'error';
                $response['error'] = 'unknown';
                $response['errorMessage'] = 'unknown';
                echo json_encode($response);
            }
        }
        
	public function actionDelete()
	{
                $response = array();
		try{
                    if(isset($_POST['id']) && is_numeric($_POST['id'])){
                        $contactMessag = ContactMessages::get($_POST['id']);
                        if(isset($contactMessag->id)){
                            $contactMessag->deleteContactMessag();
                            $response['status'] = 'ok';
                            $response['message'] = ContactMessages::getModelName('singular') . ' eliminado.';
                                    
                            Logs::log('Se eliminó el Contact Messag '.$_POST['id']);
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'noContactMessagWithId';
                            $response['errorMessage'] = 'noContactMessagWithId';
                        }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'noData';
                        $response['errorMessage'] = 'noData';
                    }
                    echo json_encode($response);
		}
		catch (Exception $ex)
		{
                    Errors::log('Error en ContactMessagesController/actionDelete',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}
        
        public function actionSend(){
            $response = array();
            
            try{
                if(isset($_POST['message']) && is_array($_POST['message'])){
                    $message = $_POST['message'];
                    if(isset($message['name']) && isset($message['email']) && isset($message['message'])){
                        
                        $contactMessage = ContactMessages::create($message['name'], $message['email'], $message['message']);
                        
                        /*$user = Users::getByEmail($contactMessage->reply_address);
                        if($user == false){
                            $user = Users::create($message['name'], $message['email'], $message['phone'], UserCategories::$LEAD, $message['area']);
                            $added = MailchimpHelper::subscribe($user);
                            if(!$added){
                                Alerts::log("Error in ContactMessages/actionSend", "Unable to subscribe user to mailchimp", "User: ".$user->id." Category: ".UserCategories::$LEAD);
                            }
                        }
                        
                        $body = '<b>Nombre:</b> '.$contactMessage->name.'<br/><br/>';
                        $body .= '<b>Email:</b> '.$contactMessage->reply_address.'<br/><br/>';
                        $body .= '<b>Teléfono:</b> '.$contactMessage->phone.'<br/><br/>';
                        $body .= '<b>Asunto:</b> '.$contactMessage->about.'<br/><br/>';
                        $body .= '<b>Mensaje:</b> '.$contactMessage->message.'<br/><br/><br/>';
                        $body .= '<b>Fecha:</b> '.$contactMessage->created_on;

                        foreach(Yii::app()->params['emails']['info'] as $contactEmail){
                            EmailHelper::sendContact($contactEmail, $contactMessage->name, $body);
                        }*/

                        $response['status'] = 'ok';
                        $response['message'] = 'Recibimos tu mensaje y nos contactaremos en la brevedad.';
                        }
                        
                    }else{
                        $response['status'] = 'error';
                        $response['error'] = 'invalidData';
                        $response['errorMessage'] = 'invalidData';
                    }
            } catch (Exception $ex) {
                    Errors::log('Error en ContactMessagesController/actionSend',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
            }
            echo json_encode($response);
        }
        
}
?>