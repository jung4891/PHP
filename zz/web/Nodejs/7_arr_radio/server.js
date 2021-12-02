var express = require('express');
var http = require('http');
var app = express();
var server = http.createServer(app).listen(80);

app.get('/arr', function (req, res) {
  res.sendfile("src/arr.html")
});

app.get('/radio', function (req, res) {
  res.sendfile("src/radio.html")
});

app.get('/radio0', function (req, res) {
  res.sendfile("src/radio0.html")
});

app.get('/professor', function (req, res) {
  res.sendfile("src/professor.html")
});
