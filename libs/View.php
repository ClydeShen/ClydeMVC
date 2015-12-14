<?php

class View {
    public function __construct() {
    }

    public function render($name, $noInclude = false) {
//        echo "render to ".$name;
        require 'Views/'.$name . '.php';
    }

}
