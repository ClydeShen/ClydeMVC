<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
        if (isset($this->css)) {
            foreach ($this->css as $css) {
                echo '<link rel="stylesheet" type="text/css" href="' .Url::_CSS($css). '"/>';
            }
        }
        ?>
        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <?php View::RenderBody(); ?>
    </body>
     <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                echo '<script type="text/javascript" src="'. Url::_JS($js) .'"></script>';
            }
        }
        ?>
</html>
