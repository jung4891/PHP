var express = require('express');
var http = require('http');
var app = express();
var server = http.createServer(app).listen(80);

app.get('/text', function (req, res) {
    res.send('here is main~~')      // text를 전달함(그러면 브라우저가 자의적으로 html형식 넣어서 body안에 text 넣음)
  });

app.get('/', function (req, res) {
    res.sendfile('html/main.html')      
  }); 

// 서버를 통해 db에 쿼리 날림 (요청/응답이 아닌 그냥 쿼리문만 날리는거면 위 express등등 설정 안해도 된다.)
let mysql = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '1234',
  database : 'test'
});

// connection.query('SELECT * FROM news', function(err, rows, fiedls){
//   console.log(rows);    // [ RowDataPacket { no: 1, title: 'a', content: '테스트' } ]
// });

// connection.query(`INSERT INTO news (title, content) VALUES ('3', 'c');`, function(err, rows, fiedls){
//   console.log(rows);    // OkPacket {.. affectedRows: 1, .. }
// }); 

app.get('/insertNews', function(req, res) {
  connection.query(`INSERT INTO news (title, content) VALUES ('${req.query.title}', '${req.query.content}')`,  
    function(error, results, fields) {
      if (error) res.send("fail");
      res.send("success");
  });
});