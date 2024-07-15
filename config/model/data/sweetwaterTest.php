<?php

require_once (__DIR__ . '/../../includes/dbDataModel.php');

class SweetwaterTest extends DbDataModel {
	const class_name = "SweetwaterTest";

    protected $orderid;
    protected $comments;
    protected $shipdateExpected;

    public function getOrderid() {
        return $this->orderid;
    }

    public function setOrderid($orderid) {
        $this->orderid = $orderid;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function getShipdateExpected() {
        return $this->shipdateExpected;
    }

    public function setShipdateExpected($shipdateExpected) {
        $this->shipdateExpected = $shipdateExpected;
    }

}
?>