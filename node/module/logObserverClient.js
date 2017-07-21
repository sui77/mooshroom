var client = {

    _io: null,

    _name: '',

    _client: null,

    _isConnected: false,

    _buf: '',

    observe: function (name) {
        console.log("observe " + name);
        var self = this;
        self._redis.hmget('mcadmin:server:' + name, 'name', 'host', function(err, r2) {
                    console.log(r2);
                    console.log(n + " " + self._name + "  | " + r2[1]);
                    if (self._name == r2[1]) {
                        console.log('client write...');
                        self._redis.hget('mcadmin:hosts:' + self._name, 'home', function(err, r3) {

                            self._client.write('observe ' + r2[0].trim() + ' ' + r3 + '/moo_' + r2[0].trim() + '/logs/latest.log|||');
                        });

                    }

        });
    },

    observeAll: function(name) {
        var self = this;
        self._redis.smembers('mcadmin:server', function(err,r) {
            for (var n in r) {
                self.observe(r[n]);
            }
        });

    },

    _redis: require("redis").createClient( serverConfig.redis  ),

    connect: function(host, port) {

        self = this;

        if (this._isConnected) {
            return;
        }

        var net = require('net');
        this._client = net.Socket();

      //  console.log('Connecting to ' + host + ' ' + port);

        this._client.connect(port, host, function() {
            self.observeAll();
            console.log('Connected to logserver ' + host);
        });

        this._client.on('error', function(ex) {
            self._isConnected = false;
            console.log(ex);
        });

        this._client.on('data', function(data) {

            var tmp = (self._buf + data.toString()).split('|||');
            if ( tmp[ tmp.size -1] != '') {
                self._buf = tmp.pop();
            }

            for (n in tmp) {

                var tmp2 = tmp[n].toString().trim().split(' ');

                var name = tmp2.shift();
                self._io.io.to(name).emit( 'log', tmp2.join(' ') );
                console.log(name + "|" + tmp2.join(' '));
            }



        });

        this._client.on('connect', function(data) {
            console.log('connected');
            self._isConnected = true;
        });

        this._client.on('close', function() {
            self._isConnected = false;
           // console.log('Connection closed');
        });
    },

    init: function(host, port, name, io) {
        this._io = io;
        this._name = name;
        self = this;
        setInterval(function() { self.connect(host, port); } , 1000);
    },

}

module.exports = client;