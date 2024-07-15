<?php

if (!class_exists('DbDataModel')) {
    class DbDataModel implements JsonSerializable {
        /**
         * Constructor - load data from DB
         */
        public function __construct($data = null) {
            if ($data) {
                foreach($data as $key => $value) {
                    $this->{$key} = $value;
                }
            }
        }

        /**
         * magic setter for DB compatibility
         * includes a custom setter call for ConnectionLibraries
         */
        public function __set($name, $value) {
            $name = trim($name);
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
                return true;
            }
            $camelCaseName = preg_replace_callback('/_([a-z])/', function($c){ return strtoupper($c[1]);}, strtolower(
                    $name));
            if ($camelCaseName == $name) {
                // lowercase, nospace. if we are here, the property doesnt exist.
                return false;

            }
            $this->__set($camelCaseName, $value);
        }

        /**
         * reformat for JSON array output
         */
        public function jsonSerialize():mixed {
            $array = array();
            foreach($this as $key => $value) {
                $array[$key] = $value;
            }
            return $array;
        }
    }
}

?>