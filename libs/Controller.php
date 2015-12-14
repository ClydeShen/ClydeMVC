<?php

class Controller {

    public function __construct() {
        $this->view = new View();
    }

    /**
     * 
     * @param string $name Name of the model
     * @param string $path Location of the models
     */
    public function loadModel($name, $path) {
        $modelName = $name . '_Model';
        $file = $path . $modelName . '.php';
        if (file_exists($file)) {
            require $file;
            $this->model = new $modelName();
        }
    }

}
