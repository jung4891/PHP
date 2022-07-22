var express = require('express');
var http = require('http');
var app = express();
var server = http.createServer(app).listen(80);

let mysql = require('mysql');
var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '1234',
  database: 'test'
});
connection.connect(); // 로그인하는거임 하이디sql


app.get('/arr', function (req, res) {
  res.sendfile("src/arr.html")
});
