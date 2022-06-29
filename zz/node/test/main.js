var http = require('http');
var fs = require('fs');
var url = require('url');
let qs = require('querystring');
let template = require('./lib/template.js');
let path = require('path');

var app = http.createServer(function(request,response){
    var _url = request.url;
    let parse_url = url.parse(_url, true);    // 하단 주석
    var pathName = parse_url.pathname;
    var queryStr = parse_url.query;
    // let filteredId = path.parse(title).base;    // ../password.js -> password.js
    console.log(pathName);                      // (경로 탐색못하게 보안적으로 막음)

    if(pathName === '/'){
      if(queryStr.title === undefined) {
        fs.readdir('./data', function(err, files) {
          let title = 'Welcome!';
          let description = "환영합니다!~!";
          let list = template.List(files);
          let html = template.HTML(title, list,
            `<h2>${title}</h2><p>${description}</p>`,
            `<a href="/create">생성<a>`);
          response.writeHead(200);
          response.end(html);
        });
      }else {
        fs.readdir('./data', function(err, files) {     // [ 'CSS', 'HTML', 'JavaScript' ]
          fs.readFile(`data/${queryStr.title}`, 'utf8', function(err, description){
            let title = queryStr.title;
            let list = template.List(files);
            let html = template.HTML(title, list,
              `<h2>${title}</h2><p>${description}</p>`,
              `<a href="/create">생성<a>
                <a href="/update?id=${title}">수정</a>
                <form action="/delete_process" method="post" onsubmit="return confirm('정말 삭제?')">
                <input type="hidden" name="title" value="${title}">
                <input type="submit" value="삭제">
                </form>`);
            response.writeHead(200);
            response.end(html);
          });
        });
      }
    }else if(pathName == '/create') {
      fs.readdir('./data', function(err, files) {
        let title = 'WEB - Create';
        let list = template.List(files);
        var html = template.HTML(title, list, `
          <form class="" action="http://localhost:4000/create_process" method="post">
            <p><input type="text" name="title" placeholder="제목"></p>
            <p><textarea name="description" rows="8" cols="80" placeholder="내용"></textarea></p>
            <p><input type="submit" value="전송"></p>
          </form>
          `, '');
        response.writeHead(200);
        response.end(html);
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
        let list = template.List(files);
        fs.readFile(`data/${queryStr.id}`, 'utf8', function(err, content){
          let control = `<a href="/create">생성<a> <a href="/update?id=${title}">수정</a>`;
          var html = template.HTML(title, list,
            `
            <form class="" action="/update_process" method="post">
              <input type="hidden" name="id" value="${title}">
              <p><input type="text" name="title" placeholder="제목" value="${title}"></p>
              <p><textarea name="description" rows="8" cols="80" placeholder="내용">${content}</textarea></p>
              <p><input type="submit" value="전송"></p>
            </form>
            `, control);
          response.writeHead(200);
          response.end(html);
        });
      })
    }else if(pathName === '/update_process') {
      let body = '';
      request.on('data', function(data) {
        body = body + data;
      });
      request.on('end', function() {
        let post = qs.parse(body);
        let id = post.id;
        let title = post.title;
        let description = post.description;

        fs.rename(`data/${id}`, `data/${title}`, function(err) {
          fs.writeFile(`./data/${title}`, description, 'utf8', function(err) {
            response.writeHead(302, {
                Location : `/?id=${title}`
              });
              response.end();
          })
        })
      })
    }else if(pathName === '/delete_process') {
      let body = '';
      request.on('data', function(data) {
        body = body + data;
      });
      request.on('end', function() {
        let post = qs.parse(body);
        let title = post.title;
        fs.unlink(`data/${title}`, function(err) {
          console.log('deleted~!');
          response.writeHead(302, {Location : `/`});
          response.end();
        })
      })
    }else {
      response.writeHead(404);
      response.end('Not Found');
    }
});
app.listen(4000);


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
