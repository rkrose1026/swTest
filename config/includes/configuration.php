<?php

$debugMode = 1;//0 off, anything else on
$debugArray = array();

define('SERVER_ROOT', $_SERVER["DOCUMENT_ROOT"]);
    $debugArray['SERVER_ROOT'] = SERVER_ROOT;

define('CONFIG_ROOT', SERVER_ROOT . "/../../config");
    $debugArray['CONFIG_ROOT'] = CONFIG_ROOT;



define('DATA_DIRECTORY', CONFIG_ROOT . '/model/data'); //TODO REMOVE Formerly CUSTOMER_DATA_DIRECTORY
    $debugArray['DATA_DIRECTORY'] = DATA_DIRECTORY;

define('SERVICES_DIRECTORY', CONFIG_ROOT . '/model/services');//TODO REMOVE Formerly CUSTOMER_SERVICES_DIRECTORY
    $debugArray['SERVICES_DIRECTORY'] = SERVICES_DIRECTORY;


    
/********************************************************************
     */

     if($debugMode != 0) {
        echo "<BR><BR>ConfigDebug<BR><BR>";

        if(!empty($debugArray)){
            foreach($debugArray as $key=>$value){
                echo $key."<BR>";
                echo "<span style='display:inline-block;text-indent:20px;color:blue;'>".$value."</span><BR>";
                if(is_dir($value)){
                    echo "<span style='display:inline-block;text-indent:40px;color:green'>Directory exists</span>";
                } else {
                    echo "<span style='display:inline-block;text-indent:40px;color:red'>Directory DOES NOT exist</span>";
                }
                echo "<BR><BR>";

            }
        }
    }

/* 
********************************************************************/

?>