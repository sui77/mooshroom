

serverConfig = require('./config/default.js');

Tail = require('tail').Tail;


var tails = {};

var net = require('net');
var server = net.createServer(function(socket) {

    socket.buf = "";

    socket.on('data', function(data) {
console.log(data);
        socket.tails = {};

        var tmp = (socket.buf + data.toString()).split('|||');
        if ( tmp[ tmp.size -1] != '') {
            socket.buf = tmp.pop();
        }

        for (n in tmp) {

            var tmp2 = tmp[n].toString().trim().split(' ');
            if (tmp2[0] == 'observe') {
                var name = tmp2[1];
                var path = tmp2[2];
                console.log("===" + name + "===");
                console.log('observing ' + name + " (" + path + ")\n");
                if (typeof tails[name] != 'undefined') {
                    tails[name].unwatch();
                    delete (tails[name]);
                }

                try {
                    tails[name] = new Tail(path);
                    tails[name].name = name;
                    tails[name].on("line", function (data) {
                        socket.write(this.name + ' ' + data + '|||');
                        console.log(name);
                        console.log(data);
                        console.log("============");
                    });

                    tails[name].on("error", function (error) {
                        delete(tails[name]);
                        console.log('ERROR: ', error);
                    });
                } catch ( e) {
                    delete(tails[name]);
                    console.log(e.toString());
                }


            }
        }


        /*
        var tmp = data.toString().trim().split(' ');
        if (tmp[0] == 'observe') {
            var name = tmp[1];
            console.log("===" + name + "===");
            console.log('observing ' + name + "\n" );
            if (typeof tails[name] == 'undefined') {

                tail = new Tail("/home/minecraft/mc_" + name + "/logs/latest.log");
                tail.on("line", function(data) {
                    client.write(name + ' ' + data);
                    console.log(data);
                    console.log("============");
                });

                tail.on("error", function(error) {
                    console.log('ERROR: ', error);
                });


            }
        }*/

    });

    socket.on('error', function(e) {
        console.log(e);
    });

    console.log('Connection from ... somewhere');
});

server.listen(1337, '127.0.0.1');


/*
var net = require('net');
var client = net.Socket();
client.connect(1337, '127.0.0.1', function() {
    console.log('Connected to logserver')
}) ;*/


