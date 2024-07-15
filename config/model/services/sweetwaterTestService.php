<?php
require_once (__DIR__ . '/../../includes/configuration.php');
require_once (INCLUDES_DIRECTORY . '/extendedDb.php');
require_once (DATA_DIRECTORY . '/sweetwaterTest.php');

class SweetwaterTestService {
	private $db;

	function __construct(&$db) {
		$this->db = $db;
	}

    function getAllData(){
		if (isset($this->db) && $this->db->execute(
				"call GET_ALL_DATA()",
			array())) {
			return $this->db->fetch_objects(SweetwaterTest::class_name);
        }
		
		return false;
	}


    function mysqlUpdateShipdate(){
        if (isset($this->db) && $this->db->execute(
                "call MYSQL_UPDATE_SHIPDATE()",
            array())) {
            return $this->db->fetch_objects(SweetwaterTest::class_name);
        }
        
        return false;
    }

    function mysqlRevertShipdate(){
        if (isset($this->db) && $this->db->execute(
                "call MYSQL_REVERT_SHIPDATE()",
            array())) {
            return $this->db->fetch_objects(SweetwaterTest::class_name);
        }
        
        return false;
    }

    function phpUpdateShipdate($order, $date){
        if (isset($this->db) && $this->db->execute(
            "call PHP_UPDATE_SHIPDATE(?,?)",
        array($order, $date))) {
        return $this->db->fetch_objects(SweetwaterTest::class_name);
    }
    
    return false;

    }


}
?>