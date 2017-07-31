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
        $('body').append('<div id="websocketError" style="z-index:99999;position:fixed;right:0;bottom:0;background-color:#f00;color:#fff;font-weight:bold;;padding:5px;">websocket not authenticated!</div>');
    }

    var showWebsocketError = function () {
        $('#websocketError').remove();
        $('body').append('<div id="websocketError" style="z-index:99999;position:fixed;right:0;bottom:0;background-color:#f00;color:#fff;font-weight:bold;;padding:5px;">websocket not connected!</div>');
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

    myIo.on('gamerule', function(key, value) {
        $.notify({message: "GameRule: " + key + " changed to " + value},{type: 'warning',timer: 1000});
       console.log("x" + key, value);
    });

    myIo.on('useradm', function(event, name) {
       if (event == 'op') {
           $.notify({message: name + " was opped."},{type: 'info',timer: 1000});

       } else if (event == 'deop') {
           $.notify({message: name + " was deopped."},{type: 'info',timer: 1000});
           $('.op-' + name).remove();
       } else if (event == 'wla') {
           $.notify({message: name + " was added to whitelist."},{type: 'info',timer: 1000});
       } else if (event == 'wlr') {
           $.notify({message: name + " was removed from whitelist."},{type: 'info',timer: 1000});
           $('.wl-' + name).remove();

       }
    });

    myIo.on('showelem', function(name) {
        $(name).show();
    });

    myIo.on('hideelem', function(name) {
        $(name).hide();
    });

    myIo.on('status', function(value) {
        $.notify({message: "Server " + value},{type: 'warning',timer: 1000});
            $('.js-server-status').hide();
        if (value == 'stopped') {
            $('.js-server-offline').show();
        } else if (value == 'started') {
            $('.js-server-online').show();
        }
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

