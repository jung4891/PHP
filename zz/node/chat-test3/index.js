
const app = require('express')();
const server = require('http').createServer(app);
const io = require("socket.io")(server);

let port = 3000;
server.listen(port, () => {
  console.log(`listening on *: ${port} ~!!`);
});

let mysql = require('mysql');
let conn = mysql.createConnection({
  host: 'localhost',
  port: 3306,
  user: 'root',
  password: 'root',
  database: 'chat_test'
})

conn.query('SELECT * FROM chat_log', function(err, rows, fields) {

})

// app.get('/', (req, res) => {
//   res.send('<h1>Hello world</h1>');
// });

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html');
});

io.on('connection', (socket) => {
// socket.emit('msg_test', `${socket.id} 연결 되었습니다.`);         // 나에게만 전송됨
  io.emit('msg_from_server', `${socket.id}님이 입장하였습니다~!`);          // 모두에게 전송됨
  console.log(`${socket.id} : 입장`);

  socket.on('msg_from_client', (msg) => {
    io.emit('msg_from_server', `${socket.id}: ${msg}`);
  });

  socket.on('disconnect', () => {
    io.emit('msg_from_server', `${socket.id}님이 방을 나갔습니다.`);
  });

});
