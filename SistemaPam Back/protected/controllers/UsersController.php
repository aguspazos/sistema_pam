<?php
    
    class UsersController extends Controller{
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
				'actions'=>array('add','addAnotherCode'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('export'),
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

	public function actionAdd()
	{
                $response = array();
		try{
                    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['gender']) && isset($_POST['address'])&& isset($_POST['code']) && isset($_POST['ci'])){
                        if(strlen($_POST['ci']) > 3){
                            $code = Codes::getByCode($_POST['code']);
                            if($code!=false){
                                if(!$code->used){
                                    $user = Users::create($_POST['first_name'],$_POST['last_name'],$_POST['phone'],$_POST['email'],$_POST['gender'],$_POST['address'],$code->id,$_POST['ci']);
                                    if(!$user->hasErrors()){
                                        $code->useCode();
                                        if(!$code->hasErrors()){
                                            $response['status'] = 'ok';
                                            Yii::app()->session['user_id'] = $user->id;
                                            Logs::log('Se creó el User '.$user->id);
                                        }
                                        else{
                                            $response['status'] = 'error';
                                            $response['error'] = 'errorMarkingCodeAsUsed';
                                            $response['errorMessage'] = 'Ocurrio un error Inesperado';
                                            Alerts::log('Error in UsersController/actionAdd', 'No se pudo marcar codigo como utilizado', 'Verificar DB');
                                        }
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'errorSavingUser';
                                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($user);
                                    }
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'usedCode';
                                    $response['errorMessage'] = 'El código ya fue utilizado.';
                                }
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'invalidCode';
                                $response['errorMessage'] = 'Ingrese un código válido.';
                            }
                        }
                        else{
                            $response['status'] = 'error';
                            $response['error'] = 'invalidDocument';
                            $response['errorMessage'] = 'Ingrese un documento válido.';
                        }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'invalidData';
                        $response['errorMessage'] = 'invalidData';
                    }
                    echo json_encode($response);
                }
		catch (Exception $ex)
		{
                    Errors::log('Error en UserController/actionAdd',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}

	public function actionAddAnotherCode()
	{
                $response = array();
		try{
                    if(isset($_POST['code'])){
                            $code = Codes::getByCode($_POST['code']);
                            if($code!=false){
                                if(!$code->used){
                                    $user = Users::get(Yii::app()->session['user_id']);
                                    if($user!=false){        
                                        $user = Users::create($user->first_name,$user->last_name,$user->phone,$user->email,$user->gender,$user->address,$code->id, $user->ci);
                                        if(!$user->hasErrors()){
                                            $code->useCode();
                                            if(!$code->hasErrors()){
                                                $response['status'] = 'ok';
                                                Logs::log('Se creó el User '.$user->id);
                                            }
                                            else{
                                                $response['status'] = 'error';
                                                $response['error'] = 'errorMarkingCodeAsUsed';
                                                $response['errorMessage'] = 'Ocurrio un error Inesperado';
                                                Alerts::log('Error in UsersController/actionAdd', 'No se pudo marcar codigo como utilizado', 'Verificar DB');
                                            }
                                        }
                                        else{
                                            $response['status'] = 'error';
                                            $response['error'] = 'errorSavingUser';
                                            $response['errorMessage'] = HelperFunctions::getErrorsFromModel($user);
                                        }
                                    }
                                    else{
                                        $response['status'] = 'error';
                                        $response['error'] = 'noUser';
                                    }
                                }
                                else{
                                    $response['status'] = 'error';
                                    $response['error'] = 'usedCode';
                                    $response['errorMessage'] = 'El código ya fue utilizado.';
                                }
                            }
                            else{
                                $response['status'] = 'error';
                                $response['error'] = 'invalidCode';
                                $response['errorMessage'] = 'Ingrese un código válido.';
                            }
                    }
                    else{
                        $response['status'] = 'error';
                        $response['error'] = 'invalidData';
                        $response['errorMessage'] = 'invalidData';
                    }
                    echo json_encode($response);
                }
		catch (Exception $ex)
		{
                    Errors::log('Error en UserController/actionAddAnotherCode',$ex->getMessage(),'');
                    $response['status'] = 'error';
                    $response['error'] = 'unknown';
                    $response['errorMessage'] = 'unknown';
                    echo json_encode($response);
		}
	}

        public function actionExport() {
            //try{
                $users = Users::model()->findAll();
                foreach($users as $user){
                    $code = Codes::get($user->code_id);
                    $user->code_id = $code->code;
                }
                $this->renderPartial('/tools/export', array('models' => $users));
            /*}catch(Exception $ex){
                Errors::log('Error en UsersController/actionExport',$ex->getMessage(),'');
                $this->redirect('/index.php/site/error');
            } */
        }
}
?>