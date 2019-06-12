<?php
    class myClass{

        public function __construct(){
        
        }
        
        
        public function ShowString($mens){
        
           return "\n##Remote Class :".__CLASS__."\n##Remote Method : ".__METHOD__."\n## mSG :{$mens}";
        
        }
        
    }
?>