<?php
    Yii::import('application.extensions.*');
    include_once 'PHPExcel/PHPExcel.php';
    
    /** PHPExcel_Writer_Excel2007 */
    include_once 'PHPExcel/PHPExcel/Writer/Excel2007.php';

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set properties
    $objPHPExcel->getProperties()->setCreator(Yii::app()->params['domain']);
    $objPHPExcel->getProperties()->setLastModifiedBy(Yii::app()->params['domain']);
    $objPHPExcel->getProperties()->setTitle("Export");
    $objPHPExcel->getProperties()->setSubject("Export");
    $objPHPExcel->getProperties()->setDescription("Export");


    $currentColumn = 'C';
    $currentRow = '3';
    

    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Simple');

    $title = 'USUARIOS';
    ExcelHelper::nextRow($currentRow, $currentColumn);
    $objPHPExcel->getActiveSheet()->SetCellValue($currentColumn.$currentRow, $title);
    
    //--------------------------------------------------------------------------
    //------------------------------ TITLE  ------------------------------------
    //--------------------------------------------------------------------------
    $model = $models[0];
    $modelAttributes = $model->getAttributes($model->safeAttributeNames);
    foreach($modelAttributes as $name=>$value){
    		$objPHPExcel->getActiveSheet()->setCellValue($currentColumn.$currentRow,$name);
    		ExcelHelper::nextColumn($currentColumn);
    }
    ExcelHelper::nextRow($currentRow,$currentColumn);
    
    //--------------------------------------------------------------------------
    //------------------------------- DATA  ------------------------------------
    //--------------------------------------------------------------------------
    
    foreach($models as $model){
    	$modelAttributes = $model->getAttributes($model->safeAttributeNames);
    	foreach($modelAttributes as $name=>$value){
    		$objPHPExcel->getActiveSheet()->setCellValue($currentColumn.$currentRow,$value);
    		ExcelHelper::nextColumn($currentColumn);
    	}
        
    	ExcelHelper::nextRow($currentRow, $currentColumn);
    }
    
    
    // Save Excel 2007 file
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $date = str_replace('-', '', str_replace(':', '', str_replace(' ', '', HelperFunctions::getDate())));
    $objWriter->save(Yii::app()->basePath.'/../public_html/excelExports/export'.$date.'.xls');
    //echo('<a href="/ExcelExports/DatosAutomaticos'.$from.'a'.$to.'.xls" target="_self" style="text-decoration:underline; color:blue;">Descargar informe</a>');
    $this->redirect('/excelExports/export'.$date.'.xls');
 ?>