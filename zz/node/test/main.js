var http = require('http');
var fs = require('fs');
var app = http.createServer(function(request,response){
    var url = request.url;
    if(request.url == '/'){
      url = '/index.html';
    }
    if(request.url == '/favicon.ico'){
      response.writeHead(404);
      response.end();
      return;
    }
    response.writeHead(200);
    console.log(__dirname + url);
    console.log(__dirname);
    response.end(fs.readFileSync(__dirname + url));
    // response.end('hyuk : ' + url);
});
app.listen(4000);
