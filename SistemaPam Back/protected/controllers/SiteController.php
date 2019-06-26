<?php

class SiteController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(){
        
		try{
                        $this->currentPage='index';
                        $this->render('index');
		}
		catch (Exception $ex)
		{
			Errors::log("Error en SiteController/actionIndex",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
		  
	}
        
	public function actionRegister(){
        
		try{
                        $this->currentPage='register';
                        $this->render('register');
		}
		catch (Exception $ex)
		{
			Errors::log("Error en SiteController/actionRegister",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
		  
	}
        
	public function actionThanks(){
        
		try{
                        $this->currentPage='thanks';
			$this->render('thanks',array());
		}
		catch (Exception $ex)
		{
			Errors::log("Error en SiteController/actionThanks",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
		  
	}
        
	public function actionInfo(){
        
		try{
                        $this->currentPage='info';
			$this->render('info',array());
		}
		catch (Exception $ex)
		{
			Errors::log("Error en SiteController/actionInfo",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
		  
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
            //$this->renderPartial('error', $error);
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->renderPartial('error', $error);
	    }
	}
	

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		try
		{
                    $redirectTo = '/';
                    if(isset(Yii::app()->session['session_admin_id']))
                        $redirectTo = '/Administrators/viewLogin';
                    else if(isset(Yii::app()->session['session_client_user_id']))
                        $redirectTo = '/ClientUsers/viewLogin';

                    //session_start();
                    session_destroy();
                    Yii::app()->user->logout();
                    $this->redirect($redirectTo);
                
		}
		catch (Exception $ex)
		{
			Errors::log("Error en UsersController/actionLogout",$ex->getMessage(),'');
			$this->redirect('/Site/userError');
		}
	}
        
        public function actionCheckDuplicates(){
            $results = Yii::app()->db->createCommand('SELECT code, COUNT(*) FROM codes GROUP BY code HAVING COUNT(*) > 1')->queryAll();
            echo(count($results));
        }
        
        public function actionCreateCodes(){
            /*$codes = [];
            
            for($i=0; $i<15000; $i++){
                $randomCode = 'A'.HelperFunctions::getRandomNumber(6);
                while(Codes::model()->exists('code="'.$randomCode.'"'))
                    $randomCode = 'A'.HelperFunctions::getRandomNumber(6);
                
                Codes::create($randomCode, 0);
            }*/
            
            for($i=1112435; $i<1112995; $i++){
                if(!Codes::model()->exists('code="'.$i.'"'))
                    Codes::create($i, 1);
            }
            
            for($i=1212995; $i<1213011; $i++){
                if(!Codes::model()->exists('code="'.$i.'"'))
                    Codes::create($i, 1);
            }
            
            for($i=1213107; $i<1213395; $i++){
                if(!Codes::model()->exists('code="'.$i.'"'))
                    Codes::create($i, 1);
            }
            
            for($i=1213491; $i<1215995; $i++){
                if(!Codes::model()->exists('code="'.$i.'"'))
                    Codes::create($i, 1);
            }
        }
        
        public function actionProcessOldCodes(){
//            Yii::import('application.extensions.*');
//            require_once 'PHPExcel/PHPExcel/IOFactory.php';
//
//            $objPHPExcel = PHPExcel_IOFactory::load(Yii::app()->basePath.'/controllers/codigosViejos2.xlsx');
//            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//
//            $count = 0;
//            foreach($sheetData as $row){
//                if(true || ($count>=1000 && $count<100000)){
////                    if(strlen($row['A'])<4){
//                    if(strcasecmp($row['A'],'nros') != 0)
//                        Codes::create($row['A'], 1);
//                    //}
//                }
//                $count++;
//            }
//            
//            echo($count);
        }
        
        public function actionExportCodes(){
            /*$csvHelper = new CSVHelper;
            $csvHelper->setSeparator(',');
            $codes = Codes::model()->findAll('code LIKE "%A%" AND created_on>"2016-08-23 15:00:00"');
            
            $row = 0;
            foreach($codes as $code){
                $csvHelper->setCell($row, 0, $code->code);
                $row++;
            }
            $csvHelper->show();*/
        }
}
?>