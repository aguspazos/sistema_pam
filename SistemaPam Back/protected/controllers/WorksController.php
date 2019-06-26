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

            /*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),*/
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionAdd()
    {
        $response = array();
        try {
            $hasWorkDetails  = false;
            $hasWorkLaminates = false;
            $hasWorkRumblings = false;
            $hasWorkUv = false;
            $hasWorkBound = false;
            $workDeliver = true;

            $currentStatus = WorkStatuses::$STARTED;
            if (isset($_POST['work_details'])) {
                $hasWorkDetails = true;
            }
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

            if (isset($_POST['print_type_id']) && isset($_POST['paper_size']) && isset($_POST['paper_type_id']) && isset($_POST['prints_amount']) && isset($_POST['image_url']) && isset($_POST['notes']) && isset($this->administrator->id)) {
                $work = Works::create($_POST['print_type_id'], $_POST['paper_size'], $_POST['paper_type_id'], $_POST['prints_amount'], $_POST['image_url'], $_POST['notes'], $this->administrator->id, $currentStatus, 0);
                if (!$work->hasErrors()) {
                    if ($hasWorkDetails) {
                        WorkDetails::create($work->id, $this->administrator->id);
                    }
                    if ($hasWorkLaminates) {
                        WorkLaminates::create(
                            $work->id,
                            $_POST['work_laminates']['printing'],
                            $_POST['work_laminates']['type'],
                            $this->administrator->id
                        );
                    }
                    if ($hasWorkRumblings) {
                        WorkRumblings::create(
                            $work->id,
                            $_POST['work_rumblings']['shape'],
                            $_POST['work_rumblings']['amount'],
                            $_POST['work_rumblings']['detail'],
                            $this->administrator->id
                        );
                    }
                    if ($hasWorkUv) {
                        WorkUvs::create($work->id, $this->administrator->id);
                    }
                    if ($hasWorkBound) {
                        WorkBounds::create(
                            $work->id,
                            $_POST['work_bounds']['type'],
                            $_POST['work_bounds']['others_text'],
                            $this->administrator->id
                        );
                    }
                    WorkFinished::create($work->id, $this->administrator->id);
                    if ($workDeliver) {
                        WorkDelivers::create($work->id, $_POST['work_deliver']['client_id'], '1900-01-01 00:00:00', $this->administrator->id);
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

            if (isset($_POST['id']) && is_numeric($_POST['id']) && isset($_POST['print_type_id']) && isset($_POST['paper_size']) && isset($_POST['paper_type_id']) && isset($_POST['prints_amount']) && isset($_POST['image_url']) && isset($_POST['notes'])) {
                $work = Works::get($_POST['id']);
                if (isset($work->id)) {
                    $adminId = isset($_POST['admin_id']) ? $_POST['admin_id'] : $work->admin_id;
                    $work->updateAttributes($_POST['print_type_id'], $_POST['paper_size'], $_POST['paper_type_id'], $_POST['prints_amount'], $_POST['image_url'], $_POST['notes'], $adminId);
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
            $worksArray = array();
            $works = Works::getAll();
            foreach ($works as $work)
                $worksArray[] = HelperFunctions::modelToArray($work);

            $response['works'] = $worksArray;
            $response['status'] = 'ok';

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
            $works = Works::getAllToSend();
            $worksArray = array();
            foreach ($works as $work) {
                $worksArray[] = $work->toArray();
            }
            $response['status'] = 'ok';
            $response['trabajos'] = $worksArray;
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
            $works = Works::getAllNotFinished();
            $worksArray = array();
            foreach ($works as $work) {
                $aux = $work->toArray();
                switch ($work->current_work_status_id) {
                    case WorkStatuses::$STARTED:
                        $worksArray['started'][] = $aux;
                        break;
                    case WorkStatuses::$WITH_DETAILS:
                        $worksArray['terminaciones'][] = $aux;
                        break;
                    case WorkStatuses::$WITH_LAMINATE:
                        $aux['data'] = $work->getLaminatedData();
                        $worksArray['laminado'][] = $aux;
                        break;
                    case WorkStatuses::$WITH_RUMBLING:
                        $aux['data'] = $work->getRumbledData();
                        $worksArray['troquelado'][] = $aux;
                        break;
                    case WorkStatuses::$UV:
                        $worksArray['uv'][] = $aux;
                        break;
                    case WorkStatuses::$BOUNDED:
                        $aux['data'] = $work->getBoundedData();
                        $worksArray['enmarcado'][] = $aux;
                        break;
                }
            }
            $response['status'] = 'ok';
            $response['works'] = $worksArray;
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
        } catch (Exception $ex) {
            Errors::log('Error en WorksController/actionNextStatus', $ex->getMessage(), '');
            $response['status'] = 'error';
            $response['error'] = 'unknown';
            $response['errorMessage'] = 'unknown';
        }
        echo json_encode($response);
    }
}
