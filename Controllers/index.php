<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array();
        $this->view->js = array();
    }

    function index() {
        $this->view->title = 'Home';
        $this->view->render('index/index');
    }



}
