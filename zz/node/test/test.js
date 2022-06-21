
let fs = require('fs');


//
// console.log('A');
// let res = fs.readFileSync('sample.txt', 'utf-8');
// console.log(res);
// console.log('C');
//

// A
// aaaaaaaaaaaaaaaaaa
// bbbbbbbbbbbbbbbbb
//
// C

console.log('A');
fs.readFile('sample.txt', 'utf-8', function(err, result) {
  console.log(result);
});
console.log('C');

// A
//
// C
// aaaaaaaaaaaaaaaaaa
// bbbbbbbbbbbbbbbbb
