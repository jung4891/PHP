

let obj = {
  k1:'k1',
  f1:function() {
    console.log('f1', this.k1);
  },
  f2:function() {
    console.log('tttt');
  }
}

obj.f1();
