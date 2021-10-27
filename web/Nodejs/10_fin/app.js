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
connection.connect();


app.get('/', function (req, res) {
  res.sendfile("src/main.html")
});

app.get('/insertPage', function (req, res) {
  res.sendfile("src/insertPage.html")
});


var bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.post('/insert', function(req, res) {
  connection.query(`SELECT * FROM student
    WHERE studentNo = '${req.body.studentNo}'`,
    function(error, results, fields) {
      if (results.length==1) {
        res.send("동일한 학번이 존재합니다.")
      } else {
        connection.query(`INSERT INTO student (studentNo, studentName, javascript, python, java)
            VALUES ("${req.body.studentNo}", "${req.body.studentName}",
                     ${req.body.javascript}, ${req.body.python}, ${req.body.java})`,
          function(error, results, fields) {
            if(error) {
              console.log(error)
              res.send("x")
            } else if(results.affectedRows==1) {
              res.send("o")
            }
          })
      }
  });
});


app.get('/listPage', function(req, res) {
    res.sendfile("src/listPage.html")
});

app.get('/showList', function(req, res) {
  connection.query(`SELECT * FROM student`,
  function(error, results, fields) {
    res.send(results)
  });
});

app.get('/updatePage', function(req, res) {
  res.sendfile("src/updatePage.html")
});

app.get('/getOneStudent', function(req, res) {
  connection.query(`SELECT * FROM student WHERE no=${req.query.no}`,
    function(error, results, fields) {
      res.send(results)
  });
});

app.put('/update', function(req, res) {
  connection.query(
    `UPDATE student
     SET studentName = '${req.body.studentName}'
      , javascript = ${req.body.javascript}
      , python = ${req.body.python}
      , java = ${req.body.java}
     WHERE no = ${req.body.no}`,
      function(error, results, fields) {
        if(error) {
          console.log(error)
          res.send("x")
        } else if(results.affectedRows==1) {
          console.log(results)
          res.send("o")
        }
      })
});

app.delete('/deleteStudent', function(req, res) {
  connection.query(`DELETE FROM student WHERE no = ${req.body.no}`,
    function(error, results, fields) {
      if(error) {
        console.log(error)
        res.send("x")
      } else if(results.affectedRows==1) {
        res.send("o")
      }
  });
});

app.get('/showJsAce', function(req, res) {
  connection.query(`SELECT * FROM student ORDER BY javascript DESC`,
    function(error, results, fields) {
      res.send(results)
  });
});

app.get('/showPythonAce', function(req, res) {
  connection.query(`SELECT * FROM student ORDER BY python DESC`,
    function(error, results, fields) {
      res.send(results)
  });
});

app.get('/showJavaAce', function(req, res) {
  connection.query(`SELECT * FROM student ORDER BY java DESC`,
    function(error, results, fields) {
      res.send(results)
  });
});

app.get('/showAce', function(req, res) {
  connection.query(`SELECT * FROM student ORDER BY javascript+python+java DESC`,
    function(error, results, fields) {
      res.send(results)
  });
});
