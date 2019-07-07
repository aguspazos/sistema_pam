<?php

class WorksController extends Controller
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
                'actions' => array('add', 'getAllNotFinished', 'getAllToSend', 'nextStatus', 'getAllSent','getPreferences'),
                'users' => array('*'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'getArray', 'getAllArray', 'viewMain', 'viewAdd', 'viewEdit', 'add', 'save', 'delete',
                    'getAllNotFinished', 'nextStatus', 'getAllToSend'
                ),
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
            Errors::log('Error en WorksController/actionViewMain', $ex->getMessage(), '');
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
            Errors::log('Error en WorksController/actionViewAdd', $ex->getMessage(), '');
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
            $works = Works::getAll();

            $this->render('edit', array('id' => $id, 'works' => $works,));
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionViewEdit', $ex->getMessage(), '');
            $this->redirect('/site/userError');
        }
    }


    public function actionGetPreferences(){
        $response = array();
        try{
            if($this->administrator){
                $response['status'] = 'ok';
                $response['data'] = Preferences::getAmazonKeyAndSecret();
            }else{
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }

        }catch(Exception $ex){
            Errors::log('Error en WorkController/getPreferences', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
        }
        echo json_encode($response);
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
                $hasWorkPrints  = true;
                $hasWorkLaminates = false;
                $hasWorkRumblings = false;
                $hasWorkUv = false;
                $hasWorkBound = false;
                $workDeliver = false;

                $currentStatus = WorkStatuses::$STARTED;

                if (isset($_POST['work_laminates'])) {
                    $hasWorkLaminates = true;
                }
                if (isset($_POST['work_rumblings'])) {
                    $hasWorkRumblings = true;
                }
                if (isset($_POST['work_uvs'])) {
                    $hasWorkUv = true;
                }
                if (isset($_POST['work_bounds'])) {
                    $hasWorkBound = true;
                }
                if (isset($_POST['work_delivers'])) {
                    $workDeliver = true;
                }

                if (isset($_POST['name']) && isset($_POST['print_type_id']) && isset($_POST['paper_size']) && isset($_POST['paper_type_id']) && isset($_POST['amount']) && isset($_POST['prints_amount'])  && isset($_POST['image_url']) && isset($_POST['notes']) && isset($this->administrator->id)) {

                    if (isset($_POST['due_date']))
                        $due_date = $_POST['due_date'];
                    else $due_date = "2019-06-26 20:49:00";

                    $work = Works::create($_POST['name'],$_POST['print_type_id'], $_POST['paper_size'], $_POST['paper_type_id'],$_POST['amount'],$_POST['prints_amount'], $_POST['image_url'], $_POST['notes'], $this->administrator->id, $currentStatus, 0, $due_date);

                    if (!$work->hasErrors()) {
                        if ($hasWorkPrints) {
                            WorkPrints::create(
                                $work->id,
                                isset($_POST['work_prints']['notes']) ? $_POST['work_prints']['notes'] : "-",
                                $this->administrator->id
                            );
                        }
                        if ($hasWorkLaminates) {
                            WorkLaminates::create(
                                $work->id,
                                $_POST['work_laminates']['printing'],
                                $_POST['work_laminates']['type'],
                                isset($_POST['work_laminates']['notes']) ? $_POST['work_laminates']['notes'] : "-",
                                $this->administrator->id
                            );
                        }
                        if ($hasWorkRumblings) {
                            WorkRumblings::create(
                                $work->id,
                                $_POST['work_rumblings']['shape'],
                                $_POST['work_rumblings']['amount'],
                                $_POST['work_rumblings']['detail'],
                                isset($_POST['work_rumblings']['notes']) ? $_POST['work_rumblings']['notes'] : "-",
                                $this->administrator->id
                            );
                        }
                        if ($hasWorkUv) {
                            WorkUvs::create(
                                $work->id,
                                isset($_POST['work_uvs']['notes']) ? $_POST['work_uvs']['notes'] : "-",
                                $this->administrator->id
                            );
                        }
                        if ($hasWorkBound) {
                            if (!isset($_POST['work_bounds']['others_text']) || $_POST['work_bounds']['others_text'] == "") {
                                $otherText = "-";
                            } else {
                                $otherText = $_POST['work_bounds']['others_text'];
                            }
                            WorkBounds::create(
                                $work->id,
                                $_POST['work_bounds']['type'],
                                $otherText,
                                isset($_POST['work_bounds']['notes']) ? $_POST['work_bounds']['notes'] : "-",
                                $this->administrator->id
                            );
                        }


                        if (isset($_POST['work_finished']['notes'])) {
                            $finishNotes = $_POST['work_finished']['notes'];
                        } else {
                            $finishNotes = "-";
                        }
                        WorkFinished::create($work->id, $finishNotes, $this->administrator->id);

                        if ($workDeliver) {
                            WorkDelivers::create(
                                $work->id,
                                $_POST['work_delivers']['client_id'],
                                $_POST['work_delivers']['deliver_date'],
                                isset($_POST['work_delivers']['notes']) ? $_POST['work_delivers']['notes'] : "-",
                                $this->administrator->id
                            );
                        }
                        $response['status'] = 'ok';
                        $response['message'] = Works::getModelName('singular') . ' agregado.';
                        $response['id'] = $work->id;
                        Logs::log('Se creó el Work ' . $work->id);
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'errorSavingWork';
                        $response['errorMessage'] = HelperFunctions::getErrorsFromModel($work);
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en WorkController/actionAdd', $ex->getMessage(), '');
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
                if (isset($_POST['id']) && is_numeric($_POST['id']) && isset($_POST['name']) && isset($_POST['print_type_id']) && isset($_POST['paper_size']) && isset($_POST['paper_type_id']) && isset($_POST['amount']) && isset($_POST['prints_amount']) && isset($_POST['image_url']) && isset($_POST['notes']) && isset($_POST['due_date'])) {
                    $work = Works::get($_POST['id']);
                    if (isset($work->id)) {
                        $adminId = isset($_POST['admin_id']) ? $_POST['admin_id'] : $work->admin_id;
                        $work->updateAttributes($_POST['name'],$_POST['print_type_id'], $_POST['paper_size'], $_POST['paper_type_id'],$_POST['amount'], $_POST['prints_amount'], $_POST['image_url'], $_POST['notes'], $adminId, $_POST['due_date']);
                        if (!$work->hasErrors()) {
                            $response['status'] = 'ok';
                            $response['message'] = Works::getModelName('singular') . ' guardado.';

                            Logs::log('Se editó el Work ' . $work->id);
                        } else {
                            $response['status'] = 'error';
                            $response['error'] = 'ErrorSavingWork';
                            $response['errorMessage'] = HelperFunctions::getErrorsFromModel($work);
                        }
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'NoWorkWithId';
                        $response['errorMessage'] = 'NoWorkWithId';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionSave', $ex->getMessage(), '');
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
                    $work = Works::get($_POST['id']);
                    if (isset($work->id)) {
                        $workArray = HelperFunctions::modelToArray($work);
                        $response['status'] = 'ok';
                        $response['work'] = $workArray;
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'NoWorkWithId';
                        $response['errorMessage'] = 'NoWorkWithId';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'invalidData';
                    $response['errorMessage'] = 'invalidData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionGetArray', $ex->getMessage(), '');
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
                $worksArray = array();
                $works = Works::getAll();
                foreach ($works as $work)
                    $worksArray[] = HelperFunctions::modelToArray($work);

                $response['works'] = $worksArray;
                $response['status'] = 'ok';
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionGetAllArray', $ex->getMessage(), '');
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
                    $work = Works::get($_POST['id']);
                    if (isset($work->id)) {
                        $work->deleteWork();
                        $response['status'] = 'ok';
                        $response['message'] = Works::getModelName('singular') . ' eliminado.';

                        Logs::log('Se eliminó el Work ' . $_POST['id']);
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'noWorkWithId';
                        $response['errorMessage'] = 'noWorkWithId';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'noData';
                    $response['errorMessage'] = 'noData';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }

            echo json_encode($response);
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionDelete', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
            echo json_encode($response);
        }
    }

    public function actionGetAllToSend()
    {
        $response = array();
        try {
            if ($this->administrator) {
                $works = Works::getAllToSend();
                $worksArray = array();
                foreach ($works as $work) {
                    $worksArray[] = $work->toArray();
                }
                $response['status'] = 'ok';
                $response['trabajos'] = $worksArray;
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/getAllToSend', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
        }
        echo json_encode($response);
    }

    public function actionGetAllSent()
    {
        $response = array();
        try {
            if ($this->administrator) {
                $works = Works::getAllSent();
                $worksArray = array();
                foreach ($works as $work) {
                    $worksArray[] = $work->toArray();
                }
                $response['status'] = 'ok';
                $response['trabajos'] = $worksArray;
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/getAllToSend', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
        }
        echo json_encode($response);
    }
    public function actionGetAllNotFinished()
    {
        $response = array();
        try {
            if ($this->administrator) {
                $works = Works::getAllNotFinished();
                $worksArray = array();
                foreach ($works as $work) {
                    $aux = $work->toArray(true, true);
                    $worksArray[] = $aux;
                }
                $response['status'] = 'ok';
                $response['works'] = $worksArray;
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionGetAllNotFinished', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
        }
        echo json_encode($response);
    }



    public function actionNextStatus()
    {
        $response = array();
        try {
            if ($this->administrator) {
                if (isset($_POST['work_id'])) {
                    $work = Works::get($_POST['work_id']);
                    if ($work) {
                        $notes = isset($_POST['notes']) ? $_POST['notes'] : "";
                        $response = $work->nextStatus($notes, $this->administrator->id);
                    } else {
                        $response['status'] = 'error';
                        $response['error'] = 'noWork';
                        $response['errorMessage'] = 'No se encontró el trabajo';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error'] = 'noData';
                    $response['errorMessage'] = 'No se encontró el trabajo';
                }
            } else {
                $response['status'] = 'error';
                $response['error'] = 'unauthorized';
                $response['errorMessage'] = 'No tienes autorización para realizar esta acción';
            }
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionNextStatus', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
        }
        echo json_encode($response);
    }
}
