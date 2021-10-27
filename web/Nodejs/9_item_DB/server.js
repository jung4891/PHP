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

app.get('/item', function (req, res) {
  res.sendfile("src/item.html")
});

app.get('/itemCheck', function(req, res) {
  // console.log(items[0].price)
  // console.log(req.query.price);
  let items = [
    {name:"item1", price:1000},
    {name:"itemm2", price:5000},
    {name:"itemmm3", price:10000},
    {name:"iteem4", price:30000},
    {name:"itttem5", price:50000},
    {name:"iiiitem6", price:100000},
    {name:"iteem7", price:500000}
  ];

  let itemName = "구매불가";
  const price = req.query.price;  // const는 변경이 안된다.

  for (i in items) {
    if (items[i].price <= price) {
      itemName = items[i].name;
    }
  }
  res.send(itemName)
});

app.get('/listForm', function(req, res) {
    res.sendfile("src/listForm.html")
});

app.get('/showList', function(req, res) {
  connection.query(`SELECT * FROM item`,
  function(error, results, fields) {
    console.log(results[0])
    console.log(results[0].no)
    console.log(results[0].itemName)
    console.log(results[0].itemPrice)
    console.log(results)
    res.send(results)
  });
});

app.get('/insertForm', function(req, res) {
  res.sendfile("src/insertForm.html")
});

// POST로 할때는 아래 3줄 추가해야.... 하아.....
// 안하면 Cannot read property 'name' of undefined 애러
var bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.post('/insert', function(req, res) {
  // console.log('왜 안되지')
  connection.query(`SELECT * FROM item
    WHERE itemName = '${req.body.name}' or itemPrice = ${req.body.price}`,
  // 테이블에 no가 Auto Increment로 설정했을시 (itemName, itemPrice)를 필히 적어야함.
  // no가 없을때는 안적어도 됨.
  // POST일때는 req.body!!! not req.query
    function(error, results, fields) {
      console.log(results)
      // console.log(results[0].itemName)
      //console.log(results.length)
      // res.send(results)
      if (results.length==2) {
        res.send("동일한 이름, 가격이 각각 존재합니다(2개)")
      } else if (results.length==1) {
        if (results[0].itemName == req.body.name && results[0].itemPrice == req.body.price) {
          res.send("동일한 이름, 가격을 가진 상품이 존재합니다.")
        } else if (results[0].itemName == req.body.name) {
          res.send("동일한 이름을 가진 상품이 존재합니다.")
        } else {
          res.send("동일한 가격을 가진 상품이 존재합니다.")
        }
      } else {
        connection.query(`INSERT INTO item (itemName, itemPrice)
            VALUES ("${req.body.name}", ${req.body.price})`,
            function(error, results, fields) {
              if(error) {
                console.log(error)
                res.send("x")
              } else if(results.affectedRows==1) {
                res.send("o")
              }
            })
        }
      // if(error) {
      //   console.log(error)
      //   res.send("x")
      // } else if(results.affectedRows==1) {
      //   res.send("o")
      // }

// connection.query(`INSERT INTO item (itemName, itemPrice) VALUES ("${req.body.name}", ${req.body.price})`,

// console.log(results)
// OkPacket {
//   fieldCount: 0,
//   affectedRows: 1,
//   insertId: 0,
//   serverStatus: 2,
//   warningCount: 0,
//   message: '',
//   protocol41: true,
//   changedRows: 0
// }
  });
});

app.get('/priceCheck', function(req, res) {
  connection.query(`SELECT itemPrice
    FROM item where itemName="${req.query.name}"`,  // ``안에 ${}있으면 {}는 변수로 인식
    function(error, results, fields) {
      if (error) throw error;
      res.send(results)
  });
});

app.get('/getItems', function(req, res) {
  connection.query(`SELECT * FROM item ORDER BY itemPrice`,
    function(error, results, fields) {

      let priceTable = results;
      let itemName = "구매불가";
      const price = req.query.price;

      for (let i=0; i<priceTable.length; i++) {
        if (priceTable[i].itemPrice <= price) {
          itemName = priceTable[i].itemName;
        }
      }
      res.send(itemName)
  });
});

app.get('/updateForm', function(req, res) {
  res.sendfile("src/updateForm.html")
});

app.get('/getOneItem', function(req, res) {
  connection.query(`SELECT * FROM item WHERE no=${req.query.no}`,
    function(error, results, fields) {
      res.send(results)
  });
});

app.put('/update', function(req, res) {
  connection.query(`SELECT * FROM item
    WHERE (itemName = '${req.body.name}' or itemPrice = ${req.body.price})
      AND no != ${req.body.no}`,
    function(error, results, fields) {
      if (results.length==2) {
        res.send("동일한 이름, 가격이 각각 존재합니다(2개)")
      } else if (results.length==1) {
        if (results[0].itemName == req.body.name && results[0].itemPrice == req.body.price) {
          res.send("동일한 이름, 가격을 가진 상품이 존재합니다.")
        } else if (results[0].itemName == req.body.name) {
          res.send("동일한 이름을 가진 상품이 존재합니다.")
        } else {
          res.send("동일한 가격을 가진 상품이 존재합니다.")
        }
      } else {
        connection.query(
          `UPDATE item
           SET itemName = '${req.body.name}'
            , itemPrice = ${req.body.price}
           WHERE no = ${req.body.no}`,    // , 꼭 적어야됨!!!!!
            function(error, results, fields) {
              if(error) {
                console.log(error)
                res.send("x")
              } else if(results.affectedRows==1) {
                console.log(results)
                res.send("o")
              }
            })
        }
  });
});

app.delete('/deleteItem', function(req, res) {
  connection.query(`DELETE FROM item WHERE no = ${req.body.no}`,
    function(error, results, fgields) {
      if(error) {
        console.log(error)
        res.send("x")
      } else if(results.affectedRows==1) {
        res.send("o")
      }
  });
});
