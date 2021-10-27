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
connection.connect(); // 로그인하는거임 하이디sql
var server = http.createServer(app).listen(80);


app.get('/dic_array', function (req, res) {
  res.sendfile("src/dic_array.html")
});

app.get('/for_star', function (req, res) {
  res.sendfile("src/for_star.html")
});
