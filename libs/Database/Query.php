<?php

class Query extends PDO {

    private $_statement;
    private $_prepare;
    private $_values;

    public function __construct() {
        parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->_statement = "";
        $this->_prepare = NULL;
        $this->_values = array();
    }

    function SELECT($select = "*", $isDistinct = FALSE) {
        if (is_array($select)) {
            $select = implode(',', $select);
        }
        if ($isDistinct) {
            $this->_prepare = $this->prepare("SELECT DISTINCT " . $select);
//            $this->_statement = "SELECT DISTINCT " . $select;
        } else {
            $this->_prepare = $this->prepare("SELECT " . $select);
//            $this->_statement = "SELECT " . $select;
        }
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function INSERT($table) {
        $this->_prepare = $this->prepare("INSERT INTO " . $table);
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function DATA($data) {
        ksort($data);
        if (strstr($this->_statement, "INSERT")) {
            $fieldName = implode(', ', array_keys($data));
            $filedValue = ':' . implode(', :', array_keys($data));
            $this->_prepare = $this->prepare($this->_statement . " ($fieldName) VALUES ($filedValue);");
            foreach ($data as $key => $value) {
                $this->_values[":$key"] = $value;
            }
        }
        if (strstr($this->_statement, "UPDATE")) {
            $fieldDetails = null;
            foreach ($data as $key => $value) {
                $tempK = $key;
                if (strpos($tempK, ".")) {
                    $tempK = str_replace(".", "_", $tempK);
                }
                $fieldDetails.="$key = :update_$tempK, ";
            }
            $fieldDetails = rtrim($fieldDetails, ', ');
            $this->_prepare = $this->prepare($this->_statement . " SET " . $fieldDetails);
            foreach ($data as $key => $value) {
                $tempK = $key;
                if (strpos($tempK, ".")) {
                    $tempK = str_replace(".", "_", $tempK);
                }
                $this->_values[":update_$tempK"] = $value;
            }
        }

        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function DELETE($table) {
        $this->_prepare = $this->prepare("DELETE FROM " . $table);
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function UPDATE($table) {
        $this->_prepare = $this->prepare("UPDATE " . $table);
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function FROM($table) {
        if (is_array($table)) {
            $table = implode(',', $table);
        }
        $this->_prepare = $this->prepare($this->_statement . " FROM " . $table);
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function JOIN($table, $condition) {
        if (is_array($condition)) {
            $condition = implode(' AND ', $condition);
        }
        $this->_prepare = $this->prepare($this->_statement . " JOIN " . $table . " ON (" . $condition . ")");
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function WHERE($where, $operator = "AND") {
        $condition = null;
        if (is_array($where)) {
            if (count($where) != 0) {
                foreach ($where as $key => $value) {
                    $tempK = $key;
                    if (strpos($tempK, ".")) {
                        $tempK = str_replace(".", "_", $tempK);
                    }
                    $condition.="$key = :where_$tempK " . $operator . " ";
                }
            }
        }
        $condition = rtrim($condition, $operator . " ");

        $this->_prepare = $this->prepare($this->_prepare->queryString . " WHERE " . $condition);
        foreach ($where as $key => $value) {
            $tempK = $key;
            if (strpos($tempK, ".")) {
                $tempK = str_replace(".", "_", $tempK);
            }
            $this->_values[":where_$tempK"] = $value;
//            $this->_prepare->bindValue(":where$tempK", $value);
        }
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function LIKE($like, $operator = "AND") {
        $condition = null;
        if (is_array($like)) {
            if (count($like) != 0) {
                foreach ($like as $key => $value) {
                    $tempK = $key;
                    if (strpos($tempK, ".")) {
                        $tempK = str_replace(".", "_", $tempK);
                    }
                    $condition.="$key LIKE :like_$tempK " . $operator . " ";
                }
            }
        }
        $condition = rtrim($condition, $operator . " ");
        $this->_prepare = $this->prepare($this->_statement . " AND " . $condition);
        foreach ($like as $key => $value) {
            $tempK = $key;
            if (strpos($tempK, ".")) {
                $tempK = str_replace(".", "_", $tempK);
            }
//            $this->_prepare->bindValue(":$tempK", $value);
            $this->_values[":like_$tempK"] = $value;
        }
        $this->_statement = $this->_prepare->queryString;
        return $this;
    }

    function sendQuery($statement = null) {
        $result = null;
        if ($statement == null) {
            if (isset($this->_values) || count($this->_values) > 0) {
                $result = $this->_prepare->execute($this->_values);
            } else {
                $result = $this->_prepare->execute();
            }
        } else {
            $result = $this->query($statement);
        }
        return $result;
    }

    function _FetchObject() {
        $result = null;
        if (isset($this->_values) || count($this->_values) > 0) {
            $this->_prepare->execute($this->_values);
        } else {
            $this->_prepare->execute();
        }
        $result = $this->_prepare->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function _FetchObjects() {
        $result = null;
        if (isset($this->_values) || count($this->_values) > 0) {
            $this->_prepare->execute($this->_values);
        } else {
            $this->_prepare->execute();
        }
        $result = $this->_prepare->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    function _FetchArray() {
        $result = null;
        if (isset($this->_values) || count($this->_values) > 0) {
            $this->_prepare->execute($this->_values);
        } else {
            $this->_prepare->execute();
        }
        $result = $this->_prepare->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}
