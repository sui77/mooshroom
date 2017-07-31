<?php
header('Content-type: application/javascript');

$files = array(
    //'../assets/js/jquery-3.1.1.min.js',
    '../assets/js/jquery-ui.min.js',
    '../assets/js/perfect-scrollbar.min.js',
    '../assets/js/bootstrap.min.js',
    '../assets/js/jquery.validate.min.js',
    '../assets/js/es6-promise-auto.min.js',
    '../assets/js/moment.min.js',
    '../assets/js/bootstrap-datetimepicker.js',
    '../assets/js/bootstrap-selectpicker.js',
    '../assets/js/bootstrap-switch-tags.js',
    '../assets/js/jquery.easypiechart.min.js',
    '../assets/js/chartist.min.js',
    '../assets/js/bootstrap-notify.js',
    '../assets/js/sweetalert2.js',
    '../assets/js/jquery-jvectormap.js',
    '../assets/js/jquery.bootstrap.wizard.min.js',
    '../assets/js/bootstrap-table.js',
    '../assets/js/jquery.datatables.js',
    '../assets/js/fullcalendar.min.js',
    '../assets/js/paper-dashboard.js',


    'socket.io.js',
    'main.js',
    'websocket.js',
    'jquery.fileupload.js',

);

foreach ($files as $f) {
    echo "\n/* === " . $f . " ===*/ \n";
    include $f;

}

