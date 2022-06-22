var http = require('http');
var fs = require('fs');
var url = require('url');

var app = http.createServer(function(request,response){
    var _url = request.url;
    let parse_url = url.parse(_url, true);    // 하단 주석
    var pathName = parse_url.pathname;
    var queryStr = parse_url.query;
    var title = queryStr.id;

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
  <h1><a href="/">WEB22</a></h1>
  <ul>
  ${list}
  </ul>
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
