var express = require('express');
var http = require('http');
var app = express();

let mysql = require('mysql');
var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '1234',
  database: 'test'
});
connection.connect(); // 하이디sql에 연결함
var server = http.createServer(app).listen(80);



app.get('/jQuery__Ajax_basic', function (req, res) {
  res.sendfile("src/jQuery__Ajax_basic.html")
  console.log(req)
});

app.get('/studentInfoPractice0', function(req, res) {
  console.log(req.query.no1, req.query.no2); // 왜 안찍히지?????
  connection.query(`SELECT NO, studentNo, NAME
    FROM student where no=${req.query.no1} OR no=${req.query.no2}`,  // ``안에 ${}있으면 {}는 변수로 인식
    function(error, results, fields) {
    if (error) throw error;
        res.send(results)
  });
});

app.get('/studentInfoPractice', function(req, res) {
  connection.query(`SELECT NO, studentNo, NAME
    FROM student where no=${req.query.no}`,  // ``안에 ${}있으면 {}는 변수로 인식
    function(error, results, fields) {
    if (error) throw error;
        res.send(results)
  });
});



// 목적별로 다르게 쓴다.
app.get('/order', function(req, res) {
  // 주문을 읽어오는 로직 (SELECT)
})
app.put('/order', function(req, res) {
  // 주문을 수정하는 로직
})
app.post('/order', function(req, res) {
  // 주문을 생성하는 로직 (INSERT)
})
app.delete('/order', function(req, res) {
  // 주문을 삭제하는 로직
})
