<?php

class Result {

    private $_objectResults;
    private $_arrayResults;

    public function __construct() {
        $this->_objectResults = array();
        $this->_arrayResults = array();
    }

    function setResultAsObject($name, $result) {
        foreach ($result as $obj) {
            if (!is_object($obj)) {
                return FALSE;
            }
            $this->_objectResults[$name][] = $obj;
        }

        return TRUE;
    }

    function getResultAsObject($name) {
        return $this->_objectResults[$name];
    }

    function setResultAsArray($name, $result) {
        if (!is_array($result)) {
            return FALSE;
        }
        $this->_arrayResults[$name] = $result;
        return TRUE;
    }

    function getResultAsArray($name) {
        return $this->_arrayResults[$name];
    }

}
