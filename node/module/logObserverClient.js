var client = {

    _io: null,

    _client: null,

    _isConnected: false,

    _buf: '',

    _data: [],

    _gameRules: [],

    observe: function (id) {
        var self = this;
        self._redis.hmget('mcadmin:server:' + id, 'logfile', 'host', function(err, r) {
                    if (self._data['id'] == r[1]) {
                        console.log('observe ' + id + ' ' + r[0] + '|||');
                        self._client.write('observe ' + id + ' ' + r[0] + '|||');
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
            //console.log(ex);
        });

        this._client.on('data', function(data) {

            var tmp = (self._buf + data.toString()).split('|||');
            if ( tmp[ tmp.size -1] != '') {
                self._buf = tmp.pop();
            }

            for (n in tmp) {

                var tmp2 = tmp[n].toString().trim().split(' ');

                var name = tmp2.shift();
                var line = tmp2.join(' ');
                self._io.io.to(name).emit( 'log', line );
                self._redis.lpush('mcadmin:log:' + name, line, function(err, r) {
                    if (r > 50) {
                        self._redis.rpop('mcadmin:log:' + name);
                    }
                } );

                console.log(name + " " + line);

                var match;
                if (match = line.match(/\[Server thread\/INFO\]: Game rule (.*?) has been updated to (.*)/)) {

                    // change gamerule
                    self._redis.hset('mcadmin:server:' + name, "gamerule:" + match[1], match[2] );
                    self._io.io.to(name).emit('gamerule', match[1], match[2]);

                } else if (match = line.match(/\[Server thread\/INFO\]: Done/)) {

                    // server started
                    self._io.io.to(name).emit('status', 'started');
                    self._redis.hset('mcadmin:server:' + name, "status", "RUNNING" );

                } else if (match = line.match(/\[Server thread\/INFO\]: Stopping the server/)) {

                    // server stopped
                    self._io.io.to(name).emit('status', 'stopped');
                    self._redis.hset('mcadmin:server:' + name, "status", "STOPPED" );

                } else if (match = line.match( new RegExp ("\\[Server thread\\/INFO\\]: (" + self._gameRules.join("|") + ") = (.*)") )) {

                    // gamerule status
                    self._redis.hset('mcadmin:server:' + name, "gamerule:" + match[1], match[2] );

                } else if (match = line.match(/No game rule called \'(.*?)\' is available/)) {

                    // gamerule status
                    self._redis.hset('mcadmin:server:' + name, "gamerule:" + match[1], 'not available' );
                } else if (match = line.match(/\[Server thread\/INFO\]: Opped (.*)/) ) {
                    self._io.io.to(name).emit('useradm', 'op', match[1] );
                } else if (match = line.match(/\[Server thread\/INFO\]: De-opped (.*)/) ) {
                    self._io.io.to(name).emit('useradm', 'deop', match[1] );
                } else if (match = line.match(/\[Server thread\/INFO\]: Added (.*?) to the whitelist/) ) {
                    self._io.io.to(name).emit('useradm', 'wla', match[1] );
                } else if (match = line.match(/\[Server thread\/INFO\]: Removed (.*?) from the whitelist/) ) {
                    self._io.io.to(name).emit('useradm', 'wlr', match[1] );
                } else if (match = line.match(/\[Server thread\/INFO\]: Turned (.*?) the whitelist/) ) {
                    if (match[1] == 'on') {
                        self._io.io.to(name).emit('hideelem', '.jsl-whitelist' );
                    } else {
                        self._io.io.to(name).emit('showelem', '.jsl-whitelist');
                    }

                }

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

    init: function(host, port, id, io, gameRules) {
        this._io = io;
        this._gameRules = gameRules;

        self = this;
        self._redis.hgetall('mcadmin:hosts:' + id, function(err, r) {
            console.log('init ' + id);
            console.log(r);
            self._data = r;
            setInterval(function() { self.connect(host, port); } , 1000);
        });

    },

}

module.exports = client;