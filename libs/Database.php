<?php

class Database extends PDO {

    public function __construct() {
        parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * select
     * @param string $tableName select table name
     * @param array $select select fileds
     * @param array $condition SQL WHERE condition
     * @param array $like SQL LIKE condition
     * @param boolean $isDistinct if select  with SQL DISTINCT condition
     * @return array Result set
     */
    public function select($tableName, $select = '*', $condition = NULL, $like = NULL, $isDistinct = FALSE) {
        if (is_array($select)) {
            $select = implode(',', $select);
        }
        if ($isDistinct) {
            $sql = $this->prepare("SELECT DISTINCT " . $select . " FROM " . $tableName);
        } else {
            $sql = $this->prepare("SELECT " . $select . " FROM " . $tableName);
        }
        $sql = $this->where($sql, $condition, $like);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();
        return $result;
    }

    private function where($sql, $whereData = NULL, $likeData = NULL) {
        if ($whereData === NULL && $likeData === NULL) {
            return $sql;
        }
        $condition = null;
        if ($whereData !== NULL) {
            foreach ($whereData as $key => $value) {
                $condition.="$key=:where$key AND ";
            }
        }

        if ($likeData !== NULL) {
            foreach ($likeData as $key => $value) {
                $condition.="$key LIKE :like$key AND ";
            }
        }
        $condition = rtrim($condition, 'AND ');
        $sql = $this->prepare($sql->queryString . " WHERE " . $condition);
        if ($whereData !== NULL) {
            foreach ($whereData as $key => $value) {
                $sql->bindValue(":where$key", $value);
            }
        }
        if ($likeData !== NULL) {
            foreach ($likeData as $key => $value) {
                $sql->bindValue(":like$key", $value);
            }
        }
        return $sql;
    }

    /**
     * insert
     * @param string $tableName select table name
     * @param array $data The data to be inserted
     */
    public function insert($tableName, $data) {
        ksort($data);
        $fieldName = implode(', ', array_keys($data));
        $filedValue = ':' . implode(', :', array_keys($data));
        $sql = $this->prepare("INSERT INTO $tableName ($fieldName) VALUES ($filedValue)");
        foreach ($data as $key => $value) {
            $sql->bindValue(":$key", $value);
        }
        $sql->execute();
    }

    /**
     * update
     * @param string $tableName select table name
     * @param array $data The data to be updated
     * @param array $condition SQL WHERE condition
     * @param array $like SQL LIKE condition
     */
    public function update($tableName, $data, $condition = NULL, $like = NULL) {
        ksort($data);
        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails.="$key=:$key, ";
        }
        $fieldDetails = rtrim($fieldDetails, ', ');
        $sql = $this->prepare("UPDATE $tableName SET $fieldDetails");
        $sql = $this->where($sql, $condition, $like);
        foreach ($data as $key => $value) {
            $sql->bindValue(":$key", $value);
        }
        $sql->execute();
    }

    /**
     * delete
     * @param string $tableName select table name
     * @param array $condition SQL WHERE condition
     * @param int $condition The number of rows deleted
     * @param array $like SQL LIKE condition
     */
    public function delete($tableName, $condition = NULL, $limit = 0, $like = NULL) {
        $sql = $this->prepare("DELETE FROM $tableName ");
        $sql = $this->where($sql, $condition, $like);
        if ($limit > 0) {
            $sql = $this->prepare($sql->queryString . " LIMIT $limit");
        }
        $sql->execute();
    }

}
