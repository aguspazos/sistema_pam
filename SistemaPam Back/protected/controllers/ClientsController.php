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

            array(
                'allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('getAllArray', 'add', 'save', 'delete'),
                'users' => array('*'),
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
    public function actionViewMain()
    {
        try {

            $this->render('main');
        } catch (Exception $ex) {
            Errors::log('Error en ClientsController/actionViewMain', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewAdd()
    {
        try {

            $this->render('add', array());
        } catch (Exception $ex) {
            Errors::log('Error en ClientsController/actionViewAdd', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewEdit($id = 0)
    {
        try {
            $clients = Clients::getAll();

            $this->render('edit', array('id' => $id, 'clients' => $clients,));
        } catch (Exception $ex) {
            Errors::log('Error en ClientsController/actionViewEdit', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
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
                if (isset($clientArray['name']) && isset($clientArray['address']) && isset($clientArray['phone']) && isset($clientArray['code'])) {

                    $client = Clients::create($clientArray['name'], $clientArray['address'], $clientArray['phone'], $clientArray['code']);
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
                $response['errorMessage'] = 'No estas autorizado a realizar esta acción';
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
                if (isset($clientArray['id']) && is_numeric($clientArray['id']) && isset($clientArray['name']) && isset($clientArray['address']) && isset($clientArray['phone']) && isset($clientArray['code'])) {
                    $client = Clients::get($clientArray['id']);
                    if (isset($client->id)) {

                        $client->updateAttributes($clientArray['name'], $clientArray['address'], $clientArray['phone'], $clientArray['code']);
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
                $response['errorMessage'] = 'No estas autorizado a realizar esta acción';
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
                    $clientsArray[] = $client->toArray();

                $response['clients'] = $clientsArray;
                $response['status'] = 'ok';
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No estas autorizado a realizar esta acción';
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
                $response['errorMessage'] = 'No estas autorizado a realizar esta acción';
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
}
