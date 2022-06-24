var http = require('http');
var fs = require('fs');
var url = require('url');
let qs = require('querystring');

var app = http.createServer(function(request,response){
    var _url = request.url;
    let parse_url = url.parse(_url, true);    // 하단 주석
    var pathName = parse_url.pathname;
    var queryStr = parse_url.query;
    var title = queryStr.id;
    console.log(pathName);

    if(pathName === '/'){
      fs.readdir('./data', function(err, files) {     // [ 'CSS', 'HTML', 'JavaScript' ]
        let list = templateList(files);
        fs.readFile(`data/${title}`, 'utf8', function(err, content){
          if(title === undefined) {
            title = 'Welcome!';
            content = "환영합니다!";
          }
          var template = templateHTML(title, list, `<h2>${title}</h2><p>${content}</p>`);
          response.writeHead(200);
          response.end(template);
          // response.end(fs.readFileSync(__dirname + _url));
          // response.end(`id: ${queryData.id} / page: ${queryData.page}`);
        });
      })
    }else if(pathName == '/create') {
      fs.readdir('./data', function(err, files) {
        title = 'WEB - Create';
        let list = templateList(files);
        var template = templateHTML(title, list, `
          <form class="" action="http://localhost:4000/create_process" method="post">
            <p><input type="text" name="title" placeholder="제목"></p>
            <p><textarea name="description" rows="8" cols="80" placeholder="내용"></textarea></p>
            <p><input type="submit"></p>
          </form>
          `);
        response.writeHead(200);
        response.end(template);
      })
    }else if (pathName === '/create_process') {
      let body = '';
      request.on('data', function(data) {
        body = body + data;
        // title=%EC%A0%9C%EB%AA%A9%EB%AA%A9&description=%EB%82%B4%EC%9A%A9%EC%9A%A9
      });
      request.on('end', function() {
        let post = qs.parse(body);
        let title = post.title;
        let description = post.description;
        // [Object: null prototype] { title: '제목목', description: '내용용' }
      })
      response.writeHead(200);
      response.end('success');
    }else {
      response.writeHead(404);
      response.end('Not Found');
    }
});
app.listen(4000);

function templateHTML(title, list, body) {
  return `
  <!doctype html>
  <html>
  <head>
  <title>WEB1 - ${title}</title>
  <meta charset="utf-8">
  <style>
  body {
    background: black;
    color: white;
  }
  </style>
  </head>
  <body>
  <h1><a href="/">WEB777</a></h1>
  <ul>
  ${list}
  </ul>
  <a href="/create">파일 생성<a>
  ${body}
  </body>
  </html>
  `;
}

function templateList(fileList) {
  let list = '';
  let i = 0;
  while(i < fileList.length) {
    list += `<li><a href="/?id=${fileList[i]}">${fileList[i]}</a></li>`;
    i++;
  }
  return list;
}



/* parse_url
(true안하면 query 속성이 decode 안된상태로 객체가 아닌 문자열로 받게됨)
Url {
  protocol: null,
  slashes: null,
  auth: null,
  host: null,
  port: null,
  hostname: null,
  hash: null,
  search: '?id=HTML',
  query: [Object: null prototype] { id: 'HTML' },
  pathname: '/',
  path: '/?id=HTML',
  href: '/?id=HTML'
}
*/
