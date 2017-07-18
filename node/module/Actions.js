var actions = {

    dateFormat: require('dateformat'),

    redis: require("redis").createClient( serverConfig.redis ),

    init: function(io) {
        this.io = io;
        this.redis.select(serverConfig.redis.database );
    },

}

module.exports = actions;