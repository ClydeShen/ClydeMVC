<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->css = array('bootstrap.css',
            'main.css');
        $this->view->js = array('jquery-1.11.3.min.js',
            'bootstrap.js',
            'Chart.js');
    }

    function index() {
        $this->view->serverlist=$this->serverList();
        $this->view->title = 'Landing page';
        $this->view->render('index/index');
    }

    function serverList() {
        return $this->model->serverList();
    }

}
