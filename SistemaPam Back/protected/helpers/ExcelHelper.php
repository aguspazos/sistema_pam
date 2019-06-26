<?php

class ExcelHelper
{
    public static function nextColumn(&$column){
        
        $lastLetter = substr($column, strlen($column)-2, 1);
        $previousLetter = substr($column, 0, strlen($column)-1);
        
        $newLastLetter = '';
        
        switch($lastLetter){
            case 'A': $newLastLetter = 'B'; break;
            case 'B': $newLastLetter = 'C'; break;
            case 'C': $newLastLetter = 'D'; break;
            case 'D': $newLastLetter = 'E'; break;
            case 'E': $newLastLetter = 'F'; break;
            case 'F': $newLastLetter = 'G'; break;
            case 'G': $newLastLetter = 'H'; break;
            case 'H': $newLastLetter = 'I'; break;
            case 'I': $newLastLetter = 'J'; break;
            case 'J': $newLastLetter = 'K'; break;
            case 'K': $newLastLetter = 'L'; break;
            case 'L': $newLastLetter = 'M'; break;
            case 'M': $newLastLetter = 'N'; break;
            case 'N': $newLastLetter = 'O'; break;
            case 'O': $newLastLetter = 'P'; break;
            case 'P': $newLastLetter = 'Q'; break;
            case 'Q': $newLastLetter = 'R'; break;
            case 'R': $newLastLetter = 'S'; break;
            case 'S': $newLastLetter = 'T'; break;
            case 'T': $newLastLetter = 'U'; break;
            case 'U': $newLastLetter = 'V'; break;
            case 'V': $newLastLetter = 'X'; break;
            case 'X': $newLastLetter = 'Y'; break;
            case 'Y': $newLastLetter = 'Z'; break;
            case 'Z': $newLastLetter = 'AA'; break;
        }
        
        $column = $previousLetter.$newLastLetter;
    }
    
    public static function nextRow(&$row, &$column){
        $row++;
        $column = 'C';
    }
    
    public static function newOrdersRow(&$objPHPExcel, &$currentRow, &$currentColumn, $values){
        ExcelHelper::nextRow($currentRow, $currentColumn);
        foreach($values as $value){
            $objPHPExcel->getActiveSheet()->SetCellValue($currentColumn.$currentRow, $value);
            ExcelHelper::nextColumn($currentColumn);
        }
    }
    
}

?>