
// db말고 서버로 웹페이지만 띄우기(get)위한 아주 기초세팅.
var express = require('express');
var http = require('http');
var app = express();
var server = http.createServer(app).listen(81);

// 1)
app.get('/test', function (req, res) {
  res.sendfile("src/test.html")
});

// 2)
let items = [
  {idx:1, name:"item1", price:"11"},
  {idx:2, name:"item2", price:"22"},
  {idx:3, name:"item3", price:"33"}
];

app.get('/getList_Server', function (req, res) {
  res.send(items);
})

// 3)
let mysql = require('mysql');
var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '1234',
  database: 'test'
});
connection.connect();

app.get('/insertForm', function(req, res) {
  res.sendfile("src/insertForm.html")
})

// POST로 할때는 아래 3줄 추가해야.... 하아.....
// 안하면 Cannot read property 'name' of undefined 애러
var bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.post('/insert', function(req, res) {
  connection.query(`INSERT INTO item (itemName, itemPrice)
    VALUES ("${req.body.name}", ${req.body.price})`,
    function(error, results) {
      if(results.affectedRows==1) {
        res.send('o')
      } else if (error) {
        res.send('x')
      }
    }
  )
})

app.get('/getList_DB', function (req, res) {
  connection.query(`SELECT * FROM item`,
  function(error,results) {
    res.send(results)
  })
})

app.get('/updateForm', function(req, res) {
  res.sendfile("src/updateForm.html")
})

// post일때는 req.body이고 get일때는 req.query!!
app.get('/getOneItem', function(req, res) {
  connection.query(`SELECT * FROM item WHERE no=${req.query.no}`,
    function(error, results) {
      console.log(results)
      res.send(results)
    }
  )
})
