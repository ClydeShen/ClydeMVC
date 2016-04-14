<?php

class Model {

    public function __construct() {
        if (!empty(DB_HOST)) {
             try {
                $this->db = new Database();
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } 
    }

}
