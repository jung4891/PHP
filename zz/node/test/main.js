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
          let control = `<a href="/create">생성<a> <a href="/update?id=${title}">수정</a>`;
          if(title === undefined) {
            title = 'Welcome!';
            content = "환영합니다!";
            control = `<a href="/create">생성<a>`;
          }
          var template = templateHTML(title, list, `<h2>${title}</h2><p>${content}</p>`, control);
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
          `, '');
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

        fs.writeFile(`./data/${title}`, description, 'utf8', function(err) {
          response.writeHead(302, {       // 302 : 리다이렉션을 뜻함.
            Location : `/?id=${title}`    // 경로에 /?에서 루트인 /빼고 ?만 넣으면
          });                             // 기존 /create_precess?id= 이런식으로 이동됨. / 꼭!
          response.end();
          // response.writeHead(200);
          // response.end('saved');
        })
      })
    }else if (pathName === '/update') {   // a태그 경로가 /update/?id=~~ 이러면 안된다. /빼야함
      fs.readdir('./data', function(err, files) {
        let list = templateList(files);
        fs.readFile(`data/${title}`, 'utf8', function(err, content){
          let control = `<a href="/create">생성<a> <a href="/update?id=${title}">수정</a>`;
          var template = templateHTML(title, list,
            `
            <form class="" action="/update_process" method="post">
              <p><input type="text" name="title" placeholder="제목" value="${title}"></p>
              <p><textarea name="description" rows="8" cols="80" placeholder="내용"></textarea></p>
              <p><input type="submit"></p>
            </form>
            `, control);
          response.writeHead(200);
          response.end(template);
        });
      })
    }

    else {
      response.writeHead(404);
      response.end('Not Found');
    }
});
app.listen(4000);

function templateHTML(title, list, body, control) {
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
    ${control}
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
