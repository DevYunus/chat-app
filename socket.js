var app = require('express')();

var server = require('http').Server(app);

var io = require('socket.io')(server);

var redis = require('redis');

io.on('connection',function (socket) {
    console.log('new connection is made ');
    var redisClient = redis.createClient();
    redisClient.subscribe('message');
    redisClient.on('message',function (channel,message) {
        console.log(channel+'  '+ message);
        socket.emit(channel,message);
    });
});

server.listen(8890);
