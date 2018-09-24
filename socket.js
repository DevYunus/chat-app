var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

server.listen(3000, 'localhost');

redis.subscribe('messagesent');

redis.on('message', function(channel, message) {
    console.log(channel, message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
    io.emit('hi', 'wdw');
});
