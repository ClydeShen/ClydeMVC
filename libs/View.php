<?php

class View {
    private $partialView = null;
    public function __construct() {
    }

    public function render($name, $noInclude = false) {
//        echo "render to ".$name;
        $this->partialView=$name;
        if($noInclude)
        {
             include 'Views/'.$this->partialView.'.php';
        }else{
            include 'Views/Shared/_Layout.php';
        }
      
    }
    public function RenderBody() {
        include 'Views/'.$this->partialView.'.php';
    }

}
