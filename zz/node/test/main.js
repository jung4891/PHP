var http = require('http');
var fs = require('fs');
var url = require('url');

var app = http.createServer(function(request,response){
    var _url = request.url;
    let parse_url = url.parse(_url, true);
    var pathName = parse_url.pathname;
    var queryStr = parse_url.query;
    var title = queryStr.id;

    if(pathName === '/'){
      fs.readFile(`data/${title}`, 'utf8', function(err, content){

        if(title === undefined) {
            title = 'Welcome!';
            content = "환영합니다!";
        }

        var template = `
        <!doctype html>
        <html>
        <head>
        <title>WEB1 - ${title}</title>
        <meta charset="utf-8">
        </head>
        <body>
        <h1><a href="/">WEB</a></h1>
        <ul>
        <li><a href="/?id=HTML">HTML</a></li>
        <li><a href="/?id=CSS">CSS</a></li>
        <li><a href="/?id=JavaScript">JavaScript</a></li>
        </ul>
        <h2>${title}</h2>
        <p>${content}</p>
        </body>
        </html>
        `
        response.writeHead(200);
        response.end(template);
        // response.end(fs.readFileSync(__dirname + _url));
        // response.end(`id: ${queryData.id} / page: ${queryData.page}`);
      });
    }else {
      response.writeHead(404);
      response.end('Not Found');
    }




});
app.listen(4000);
