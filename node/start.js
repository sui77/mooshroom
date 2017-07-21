

serverConfig = require('./config/default.js');

// init socket.io
var io = require('socket.io')( {path:"/ws"} );
console.log('Starting server at port ' + serverConfig.http.port);
io.listen(serverConfig.http.port);

// cluster setup
//var ioRedis = require('socket.io-redis');
//io.adapter(ioRedis({ host: 'localhost', port: 6379 }));


// init actions
actions = require('./module/Actions.js');
actions.init(io);

// init socket.io event handler
var myIo = require('./module/io.js');
myIo.init(actions);
io.on('connection', function(socket) {
    myIo.setEventHandler(socket, io);
} );



var logObservers = [];

var redis = require("redis").createClient( serverConfig.redis  )
redis.smembers('mcadmin:hosts', function(err, r) {
    //r = ["127.0.0.1"];
    for (n in r) {
        logObservers[r[n]] = require('./module/logObserverClient.js');
        logObservers[r[n]].init('localhost', 1337, r[n], myIo);
    }
   console.log(r);
});


// log socket server
/*
var redis = require("redis").createClient( serverConfig.redis  )
var net = require('net');
var server = net.createServer(function(socket) {

    socket.on('data', function(data) {
        var tmp = data.toString().split(' ');
        tmp.pop();
        myIo.io.to(tmp[0]).emit('log', data.toString().trim() + "\n");
        redis.lpush('mcadmin:log:' + tmp[0], data.toString().trim() );
    });

    socket.on('error', function(e) {
        console.log(e);
    });
});

server.listen(1337, '127.0.0.1');
*/
