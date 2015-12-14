<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
        if (isset($this->css)) {
            foreach ($this->css as $css) {
                echo '<link rel="stylesheet" type="text/css" href="' . URL . 'public/css/' . $css . '"/>';
            }
        }
        ?>
        <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                echo '<script type="text/javascript" src="' . URL . 'public/js/' . $js . '"></script>';
            }
        }
        ?>
        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <h3>Server check</h3>
        <hr/>
        <div class="container-fluid">
            <div class="col-xs-12 col-md-3">
                <?php if (isset($this->serverlist)): ?>
                    <form id="serverSelected" class="form-horizontal" action="<?php echo URL; ?>Statistics/check/">
                        <div class="control-group">
                            <label class="control-label" for="selectserver">Select Server</label>
                            <div class="controls">
                                <select id="selectserver" name="selectserver">
                                    <?php foreach ($this->serverlist as $server): ?>
                                        <option value="<?php echo $server['id']; ?>"><?php echo $server['s_system']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="singlebutton">click to check</label>
                            <div class="controls">
                                <button class="btn btn-primary" id="submit">check value</button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
                <hr/>
                <div id="summary"></div>
            </div>
            <div class="col-xs-12 col-md-9">
                <label class="control-label" for="selectbasic" id="chartTitle">Server values graph</label>
                <div id="result">
                    <canvas id="valueCanvas" height="600" width="950"></canvas>
                </div>
            </div>
        </div>
        <script>
            $("#serverSelected").submit(function () {
                var serverName = $('#selectserver').find(":selected").text();
                var url = $(this).attr('action') + serverName;
                var canvas = $("#valueCanvas").get(0).getContext("2d");
                var labels = [], values = [];
                var min, max, avg;
                $.post(url, function (o) {
                    console.log(o);
                    obj = o;
                    labels = o['label'];
                    values = o['value'];
                    min = o['min'];
                    max = o['max'];
                    avg = o['average'];
                    var ServerData = {
                        labels: labels,
                        datasets: [
                            {
                                fillColor: "rgba(172,194,132,0.4)",
                                strokeColor: "#ACC26D",
                                pointColor: "#fff",
                                pointStrokeColor: "#9DB86D",
                                data: values
                            }
                        ]
                    }
                    var opt = {
                        pointDotRadius: 2,
                        pointDotStrokeWidth: 1,
                        pointHitDetectionRadius: 1,
                        showXLabels: 10
                    };
                    window.myLine = new Chart(canvas).Line(ServerData, opt);
                    $('#chartTitle').html('Server values graph: ' + serverName);
                    var summary = '<ul class="list-group"><li class="list-group-item"><b>Lowest:</b><br/>' + min['label'] + '<strong class="pull-right">' + min['value'] + '</strong></li><li class="list-group-item"><b>Highest:</b><br/>' + max['label'] + '<strong class="pull-right">' + max['value'] + '</strong></li><li class="list-group-item"><b>Average:</b><strong class="pull-right">' + avg['value'] + '</strong></li></ul>';
                    $('#summary').html(summary);
                }, 'json');
                return false;
            });
        </script>
    </body>
</html>
