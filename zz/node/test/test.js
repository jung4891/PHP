

let A = {
  a:'aa',
  func1:function() {
    console.log('func1', this.a);
  }
}

let test = () => {
  console.log('testttt입니다.');
}

// A.func1();
// test();

module.exports = {A, test};
