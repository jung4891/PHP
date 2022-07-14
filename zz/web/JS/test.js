
function test1() {
  test2();

  function test2() {
    console.log('abc');
  }
}

const test = {
  a: 1
}
if(test) {
  console.log('aa');
}
