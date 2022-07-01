
const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);

const { Server } = require("socket.io");
const io = new Server(server);

// app.get('/', (req, res) => {
//   res.send('<h1>Hello world</h1>');
// });

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html');
});

io.on('connection', (socket) => {
  console.log('a user connected ~~!! 123');
  // console.log('socket: ', socket);

  socket.on('disconnect', () => {
    console.log('user disconnected....');
  });

  socket.on('chat message', (msg) => {
    io.emit('chat message_test', msg);
    console.log('메시지: ' + msg);
  });
});

server.listen(3000, () => {
  console.log('listening on *:3000');
  // console.log(io);
});
