// let T = {
module.exports = {
  HTML:function(title, list, body, control) {
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
  },
  List:function(fileList) {
    let list = '';
    let i = 0;
    while(i < fileList.length) {
      list += `<li><a href="/?title=${fileList[i]}">${fileList[i]}</a></li>`;
      i++;
    }
    return list;
  }
}

// 여러 객체나 함수를 보낼때는 {T, A, B} 이런식으로 하면 되는데
// 이렇게 하면 {}안에 담기므로 호출시 중간에 객체 이름을 넣어줘야한다.
// 가령 require한 template을 template.HTML아ㅣ 아닌 template.T.HTML로 호출해야한다.
// 객체 하나만 보낼때는 아예 위의 let T를 module.exports로 해도 된다.
// module.exports = T;
