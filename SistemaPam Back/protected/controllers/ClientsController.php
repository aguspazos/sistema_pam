<?php

class ClientsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(

            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('addFromExcel'),
				'users'=>array('*'),
			),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('getArray', 'getAllArray', 'viewMain', 'viewAdd', 'viewEdit', 'add', 'save', 'delete'),
                'users' => array('@'),
                'expression' => 'isset(Yii::app()->user->role) && (Yii::app()->user->role===\'admin\')',
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(),
                'users' => array('admin'),
            ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionAdd()
    {
        $response = array();
        try {
            if ($this->administrator) {
                $clientArray = $_POST;
                if (isset($clientArray['name']) && isset($clientArray['business_name']) && isset($clientArray['rut']) && isset($clientArray['document']) && isset($clientArray['country']) && isset($clientArray['department']) && isset($clientArray['address']) && isset($clientArray['phone']) && isset($clientArray['mobile_phone']) && isset($clientArray['mail']) && isset($clientArray['second_mail'])) {

                    $client = Clients::create($clientArray['code'],$clientArray['name'], $clientArray['business_name'], $clientArray['rut'], $clientArray['document'], $clientArray['country'], $clientArray['department'], $clientArray['address'], $clientArray['phone'], $clientArray['mobile_phone'], $clientArray['mail'], $clientArray['second_mail']);
                    if (!$client->hasErrors()) {



                        $response['status'] = 'ok';
                        $response['message'] = Clients::getModelName('singular') . ' agregado.';
                        $response['id'] = $client->id;

                        Logs::log('Se creó el Client ' . $client->id);
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'errorSavingClient';
                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($client);
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No estas autorizado a realizar esta accion';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ClientController/actionAdd', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionSave()
    {
        $response = array();
        try {
            if ($this->administrator) {
                $clientArray = $_POST;
                if (isset($clientArray['id']) && is_numeric($clientArray['id']) && isset($clientArray['name']) && isset($clientArray['business_name']) && isset($clientArray['rut']) && isset($clientArray['document']) && isset($clientArray['country']) && isset($clientArray['department']) && isset($clientArray['address']) && isset($clientArray['phone']) && isset($clientArray['mobile_phone']) && isset($clientArray['mail']) && isset($clientArray['second_mail'])) {
                    $client = Clients::get($clientArray['id']);
                    if (isset($client->id)) {

                        $client->updateAttributes($clientArray['code'],$clientArray['name'], $clientArray['business_name'], $clientArray['rut'], $clientArray['document'], $clientArray['country'], $clientArray['department'], $clientArray['address'], $clientArray['phone'], $clientArray['mobile_phone'], $clientArray['mail'], $clientArray['second_mail']);
                        if (!$client->hasErrors()) {


                            $response['status'] = 'ok';
                            $response['message'] = Clients::getModelName('singular') . ' guardado.';

                            Logs::log('Se editó el Client ' . $client->id);
                        } else {
                            $response['status'] = 'error';
                            $response['error'] = 'ErrorSavingClient';
                            $response['errorMessage'] = HelperFunctions::getErrorsFromModel($client);
                        }
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'NoClientWithId';
                        $response['errorMessage'] = 'NoClientWithId';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No estas autorizado a realizar esta accion';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ClientsController/actionSave', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }



    public function actionGetArray()
    {
        try {
            if ($this->administrator) {
                if (isset($_POST['id']) && is_numeric($_POST['id'])) {
                    $client = Clients::get($_POST['id']);
                    if (isset($client->id)) {
                        $clientArray = HelperFunctions::modelToArray($client);



                        $response['status'] = 'ok';
                        $response['client'] = $clientArray;
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'NoClientWithId';
                        $response['errorMessage'] = 'NoClientWithId';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No estas autorizado a realizar esta accion';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ClientsController/actionGetArray', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionGetAllArray()
    {
        try {
            if ($this->administrator) {
                $clientsArray = array();
                $clients = Clients::getAll();
                foreach ($clients as $client)
                    $clientsArray[] = HelperFunctions::modelToArray($client);

                $response['clients'] = $clientsArray;
                $response['status'] = 'ok';
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No estas autorizado a realizar esta accion';
            }

            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ClientsController/actionGetAllArray', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionDelete()
    {
        $response = array();
        try {
            if ($this->administrator) {

                if (isset($_POST['id']) && is_numeric($_POST['id'])) {
                    $client = Clients::get($_POST['id']);
                    if (isset($client->id)) {
                        $client->deleteClient();
                        $response['status'] = 'ok';
                        $response['message'] = Clients::getModelName('singular') . ' eliminado.';

                        Logs::log('Se eliminó el Client ' . $_POST['id']);
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'noClientWithId';
                        $response['errorMessage'] = 'noClientWithId';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'noData';
                    $response['errorMessage'] = 'noData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No estas autorizado a realizar esta accion';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en ClientsController/actionDelete', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionAddFromExcel(){
                Yii::import('application.extensions.*');
                require_once 'PHPExcel/PHPExcel/IOFactory.php';
    
                $objPHPExcel = PHPExcel_IOFactory::load(Yii::app()->basePath.'/controllers/clients.xls');
                $sheetData = $objPHPExcel->getSheetByName('Clientes')->toArray(null,true,true,true);
    
                $count = 0;
                foreach($sheetData as $row){
    //                    if(strlen($row['A'])<4){
                        if(strcasecmp($row['A'],'Código cliente') != 0){
                            $client = Clients::model()->find('code = :code',array('code'=>$row['A']));
                            if(isset($client->id)){
                            
                                $client->updateAttributes($row['A'],$row['B'], $row['C'], $row['D'], $row['E'], $row['F'],$row['G'] , $row['I'], $row['L'], $row['M'], $row['O'], $row['P']);
                            }else{
                                Clients::create($row['A'],$row['B'], $row['C'], $row['D'], $row['E'], $row['F'],$row['G'] , $row['I'], $row['L'], $row['M'], $row['O'], $row['P']);
                            }
                        }
                        //}
                    $count++;
                }
                
                echo($count);

    }
}
