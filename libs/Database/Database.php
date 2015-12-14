<?php

class Database extends Query {

    private $query;
    private $results;
    private $_currentResult;

    public function __construct() {
        parent::__construct();
        $this->query = new Query();
        $this->results = new Result();
    }

    function select($select = "*", $isDistinct = FALSE) {
        $this->query->SELECT($select, $isDistinct);
        return $this;
    }

    function insert($table) {
        $this->query->INSERT($table);
        return $this;
    }

    function delete($table) {
        $this->query->DELETE($table);
        return $this;
    }

    function update($table) {
        $this->query->UPDATE($table);
        return $this;
    }

    function data($data) {
        if (!is_array($data) || count($data) == 0) {
            return FALSE;
        }
        $this->query->DATA($data);
        return $this;
    }

    function now() {
        $this->_currentResult = $this->query->sendQuery();
        $this->query = new Query();
        return $this->_currentResult;
    }

    function myQuery($statement) {
        return $this->query->sendQuery($statement);
    }

    function from($table) {
        $this->query->FROM($table);
        return $this;
    }

    function join($table, $condition) {
        $this->query->JOIN($table, $condition);
        return $this;
    }

    function where($where, $operator = "AND") {
        $this->query->WHERE($where, $operator);
        return $this;
    }

    function like($like, $operator = "AND") {
        $this->query->LIKE($like, $operator);
        return $this;
    }

    function ObjectResult() {
        $result = $this->query->_FetchObject();
        $this->query = new Query();
        return $result;
    }

    function ObjectAllResults() {
        $result = $this->query->_FetchObjects();
        $this->query = new Query();
        return $result;
    }

    function ArrayResult() {
        $result = $this->query->_FetchArray();
        $this->query = new Query();
        return $result;
    }

    function saveObjectResult($objectName = null) {
        if ($this->results->setResultAsObject($objectName, $this->_currentResult)) {
            $this->_currentResult = null;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function saveArrayResult($arrayName = null) {
        if ($this->results->setResultAsArray($arrayName, $this->_currentResult)) {
            $this->_currentResult = null;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getObjectResult($objectName = null) {
        return $this->results->getResultAsObject($objectName);
    }

    function getArrayResult($arrayName = null) {
        return $this->results->getResultAsArray($arrayName);
    }

    function clear() {
        $this->query = new Query();
    }

}
