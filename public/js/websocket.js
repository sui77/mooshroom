var appendMessage = function(d) {
    if ($('#mcconsole').length == 0) {
        return;
    }

    msg = '<div class="">';
    msg += d;
    msg += '</div>';
    msg += "\n";
    $('#mcconsole').append(msg);

    var height = $('#mcconsole')[0].scrollHeight;
    $('#mcconsole').scrollTop(height);
}

var MCAdminWs = function(hostName, userName, authToken) {

    myIo = io(hostName, {path: "/ws"});

    var showWebsocketAuthError = function () {
        $('#websocketError').remove();
        $('body').append('<div id="websocketError" style="position:fixed;right:0;bottom:0;background-color:#f00;color:#fff;font-weight:bold;;padding:5px;">websocket not authenticated!</div>');
    }

    var showWebsocketError = function () {
        $('#websocketError').remove();
        $('body').append('<div id="websocketError" style="position:fixed;right:0;bottom:0;background-color:#f00;color:#fff;font-weight:bold;;padding:5px;">websocket not connected!</div>');
    }

    var hideWebsocketError = function () {
        $('#websocketError').remove();
    }

    myIo.on('connect', function (p) {
        myIo.emit('auth', {username: userName, token: authToken}, function (r) {
            if (r) {
                hideWebsocketError();
            } else {
                showWebsocketAuthError();
            }
        });
    })

    myIo.on('log', function(data) {
        console.log(data);
        appendMessage(data);
    });

    myIo.on('disconnect', function () {
        if (!window.isUnloading) {
            showWebsocketError();
        }
    })

    myIo.on('connect_error', function () {
        showWebsocketError();
    });

    myIo.on('reconnect', function () {

    });
}

