<?php

class DB {
    const MYSQL_DRIVER = 'mysql';

    /* ****** Test Server Details ***** */
    const swTest_DRIVER = DB::MYSQL_DRIVER;
    const swTest_HOSTNAME = 'localhost';
    const swTest_PORT = 3306;
    const swTest_USER_NAME = 'swTestUser';
    const swTest_PASSWORD = 'swTestUser';
    const swTest_DATABASE_NAME = 'swTest';

    protected $db;
    protected $stmt;
	protected $status = false;
    protected $pdoError = '';


    function __construct($database, $driver = DB::swTest_DRIVER, $hostname = DB::swTest_HOSTNAME, $port = DB::swTest_PORT, $userName = DB::swTest_USER_NAME, $password = DB::swTest_PASSWORD) {
        if ($driver == DB::MYSQL_DRIVER) {
            try {
                $this->db = new PDO("$driver:host=$hostname; dbname=$database;", $userName, $password, array(
                PDO::ATTR_PERSISTENT => true));	
            } catch (PDOException $e) {
                echo "Error!:" . $e->getMessage() . "<br/>";
                    die();
            }
        } else {  
            /*no try/catch as we want the error to bubble.*/
            $this->db = new PDO("$driver:$hostname", $userName, $password);
        }
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function execute($query, $parameters = null) {
		try {
            if (($this->stmt = $this->db->prepare($query)) != false) {
                if (isset($parameters)) {
				    $this->status = $this->stmt->execute($parameters);
			    } else {
				    $this->status = $this->stmt->execute();
			    }
            }else {
               $this->status = false;
            }
		} catch(PDOException $e) {
            $this->status = false;
            $pdoError = $e->getMessage();
            error_log($pdoError);
            ob_start();
            debug_print_backtrace();
            $trace = ob_get_contents();
            ob_end_clean();
            error_log($trace);
		}
        return $this->status;
	}


}

?>