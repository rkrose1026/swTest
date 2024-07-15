<?php
require_once ('db.php');

class ExtendedDB extends DB {

    protected $errorStatus = '';

	public function __construct($database = null, $driver = DB::swTest_DRIVER, $hostname = DB::swTest_HOSTNAME, $port = DB::swTest_PORT, $userName = DB::swTest_USER_NAME, $password = DB::swTest_PASSWORD) {
		parent::__construct($database, $driver, $hostname, $port, $userName, $password);
    }

    public function getStatusMessage() {
        return $this->errorStatus;
    }

    private function _fetch() {
		$result = null;
		try {
			if ($this->status) {
				$result = $this->stmt->fetch();
			}
		} catch(PDOException $e) {
			$result = null;
            $errorStatus = $e->getMessage();
		}

		return $result;
	}

    private function _fetchAll() {

		$result = null;
		try {
			if ($this->status) {
				$result = $this->stmt->fetchAll();
			}
		} catch(Exception $e) {
			$result = null;
            $this->status = false;
            $pdoError = $e->getMessage();
            error_log($pdoError);
            ob_start();
            debug_print_backtrace();
            $trace = ob_get_contents();
            ob_end_clean();
            error_log($trace);
            $errorStatus = $pdoError;
		}

        return $result;
    }

	public function fetch_object($classname) {
		if (class_exists($classname)) {
			$this->stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $classname);
		}
		return $this->_fetch();
	}

    public function fetch_objects($classname) {
		if (class_exists($classname)) {
			$this->stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $classname);
		}
		return $this->_fetchAll();
	}
}

class LocalhostDB extends ExtendedDB {

	function __construct() {
		parent::__construct(
				DB::swTest_DATABASE_NAME,
				DB::swTest_DRIVER,
				DB::swTest_HOSTNAME,
				DB::swTest_PORT,
				DB::swTest_USER_NAME,
				DB::swTest_PASSWORD);
	}
}

?>