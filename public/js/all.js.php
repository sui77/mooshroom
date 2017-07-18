<?php
header('Content-type: application/javascript');

//include('custom.min.js');
include('socket.io.js');


include('jquery.ui.widget.js');
/*include('../vendor/jQuery-File-Upload-9.18.0/js/jquery.iframe-transport.js');*/
include('jquery.fileupload.js');
?>
$(function() {
    $('.right_col').css("min-height", $(window).height());
})
<?php

include('main.js');
include('websocket.js');
echo "\n";
include('switchery.js');