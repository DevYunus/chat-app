var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('message-sent');

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message.event);
    io.emit(channel + ':' + message.event, message.data);
    io.emit('hi', 'hh');
    console.log('dwd');
});

server.listen(3000);
