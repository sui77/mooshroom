

var pio = {

    redis: require("redis").createClient( serverConfig.redis  ),
    io: null,

    init: function(actions) {
        this.actions = actions;
        this.redis.select( serverConfig.redis.database );
    },

    isTokenValid: function(user, token, cb) {
        cb(true); return;
        this.redis.lrange('user:' + user + ':auth', 0, 10, function(err, r) {
            for (n in r) {
                if (r[n] == token) {
                    cb(true);
                    return;
                }
            }
            cb(false);
        });
    },

    setEventHandler: function(socket, io) {
        var self = this;
        self.io = io;

        socket.userdata = {
            name: 'anonymous',
            server: null,
        }


        socket.join('all');

        socket.on('auth', function(d, cb) {
            console.log('auth', d);
            var cb = typeof cb == "function" ? cb : function() {};
            self.isTokenValid(d.username, d.token, function(r) {
                if (r) {
                    self.redis.hgetall('mcadmin:user:' + d.username, function(err, r2) {
                        console.log('mcadmin:user:' + d.username);
                        console.log(r2);
                        if (r2 != null) {
                            socket.userdata = r2;
                            socket.userdata.name = d.username;
                            socket.join('user-' + d.username);
                            if (socket.userdata.admin) {
                                socket.join('admin');
                            }
                            cb(true);
                        } else {
                            cb(false);
                        }
                    });
                } else {
                    cb(false);
                }
            });
        });

        socket.on('disconnect', function() {

        });

        socket.on('join', function(channel) {
            socket.join(channel);
        });
    },


}
module.exports = pio;