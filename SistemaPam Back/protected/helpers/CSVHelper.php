<?php

class CSVHelper
{
        public $fileArray=array();
        public $name='file';
        public $separator=',';
        public $maxRow=0;
        public $maxCol=0;
        
        
        public function setName($name){
        	$this->name = $name;
        }
        
        public function setSeparator($separator){
        	$this->separator = $separator;
        }
        
        public function setCell($row, $col, $data){
            if(!isset($this->fileArray[$row]))
                $this->fileArray[$row] = array();
            
            $this->fileArray[$row][$col] = $data;
            
            if($this->maxRow<$row)
                $this->maxRow = $row;
            
            if($this->maxCol<$col)
                $this->maxCol = $col;
        }
        
        public function show(){
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$this->name.".csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            
            $csvContent = '';
            
            for($x=0; $x<=$this->maxRow; $x++){
                for($y=0; $y<=$this->maxCol; $y++){
                    if(isset($this->fileArray[$x]) && is_array($this->fileArray[$x]) && isset($this->fileArray[$x][$y])){
                        $csvContent .= $this->fileArray[$x][$y].$this->separator;
                    }
                    else{
                        $csvContent .= $this->separator;
                    }
                }
                $csvContent .= "\n";
            }
            echo $csvContent;
        }
}
?>