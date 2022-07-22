var express = require('express');
var http = require('http');
var app = express();

// let oracle = require('oracle');
// var connection = oracle.createConnection({
//   host: 'localhost',
//   user: 'SYSTEM',
//   password: 'manager',
//   database: 'LOCAL_ORACLE'
// });

  let mysql = require('mysql');
  var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '1234',
    database: 'test'
});

connection.connect(); // 로그인하는거임 하이디sql
var server = http.createServer(app).listen(80);

app.get('/if_typeof', function (req, res) {    // 1
  res.sendfile("src/if_typeof.html")
});

app.get('/ajax_post', function (req, res) {    // 1
  res.sendfile("src/ajax_post.html")
});

// POST로 할때는 아래 3줄 추가해야함. 그리고 req.body.~ 로 써야함.
var bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.post('/student', function(req, res) {
  connection.query(      // 5 (받은 req로 db에 쿼리문 실행)
    `INSERT INTO student
    (studentNo, NAME, age)
    VALUES
    ('${req.body.studentNo}', '${req.body.NAME}', ${req.body.age})`,
    function(error, results, fields) { // 6 (db실행되면 res 옴)
      if(error) {
        res.send("not ok")
      } else if(results.affectedRows==1) {
        res.send("ok")
      }
        // res.send(results)
  });
});

// test1.html에서 input버튼을 누르면 ajax가 data를 담고 req를 한다.
// 이 req를 실행해서 db에 아래 쿼리를 실행하면 아래 fuction 내부가 작동하고
// (만일 db가 먹통이면 내부가 작동을 안한다.)
// 그 res를 $("#postStdInfoBtn").click(function(){ 의 success: function의 res로
// 응답을 보내고 그 응답이 브라우저콘솔에 찍히게 되는 구조임.

app.post('/studentMod', function(req, res) {
  connection.query(
    `UPDATE student
    SET NAME='${req.body.NAME}', age=${req.body.age}
    WHERE NO = 7`,
    function(error, results, fields) {
        res.send(results)
  });
});

app.get('/if', function (req, res) {
  res.sendfile("src/if.html")
});
