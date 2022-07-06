
const app = require('express')();
const server = require('http').createServer(app);
const io = require("socket.io")(server, { cors: { origin: "*" } });

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

let nicknames = []

// app.get('/', (req, res) => {
//   res.send('<h1>Hello world</h1>');
// });

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html');
});

io.on('connection', (socket) => {

  socket.on('login', (nickname) => {
    // console.log(nickname, socket.id);

    //로그인하면 nicknames 배열에 nickname과 socketID를 추가
    let nicknameExist = false
    for(let i=0; i<nicknames.length; i++){
      if(nicknames[i].nickname == nickname){
        nicknameExist = true
        break;
      }
    }
    if(nicknameExist) {
      socket.emit('loginFail');
    }else {
      conn.query('SELECT * FROM (SELECT * FROM chat_log ORDER BY NO DESC LIMIT 10) a ORDER BY NO',
      function(err, rows, fields) {
        nicknames.push({nickname: nickname, socketID: socket.id});
        socket.emit('loginSuccess', rows)                                 // 나에게만 전송됨
        io.emit('msg_from_server', `${nickname}님이 입장하였습니다~!`);    // 모두에게 전송됨
      })
    }
  });

  socket.on('msg_from_client', (msg) => {
    let nickname = ""
    for(let i=0; i<nicknames.length; i++){
      if(nicknames[i].socketID == socket.id){
        nickname = nicknames[i].nickname
      }
    }
    conn.query(`INSERT INTO chat_log (nickname, msg) values ('${nickname}','${msg}')`,
    function(err, rows, fields){
      io.emit('msg_from_server', {nickname: nickname, msg: msg})
      // io.emit('msg_from_server', `${socket.id}: ${msg}`);
    })

  });

  socket.on('disconnect', () => {                // 사용자가 나가면(로그아웃) 배열에서 소켓id삭제함
    for(let i=0; i<nicknames.length; i++){
      if(nicknames[i].socketID == socket.id){
        let nickname = nicknames[i].nickname;
        io.emit('msg_from_server', `${nickname}님이 방을 나갔습니다.`);
        nicknames.splice(i,1)
      }
    }
  });
  console.log('1', nicknames);
});
  console.log('2', nicknames);
