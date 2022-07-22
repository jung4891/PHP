
let test = function() {
  console.log('^^');
}
// test();

function slowFunc(callback) {
  console.log('1');
  callback();
  console.log('2');
}

slowFunc(test);
