
const arr = [1, 22, 333];
const res = arr.map( (val, idx, src) => {
  console.log('idx', idx);
  console.log('val', val);
  console.log('src', src);
  arr.pop();
  console.log('src2', src);

  return val * val;
});
console.log(res);
