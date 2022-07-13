
// 문자열을 문자 단위로 쪼개어 배열로 만들거나
// const arr = Array.from('hyuk');

// 아규먼트를 배열로 만들 수 있습니다.
function f() { return Array.from(arguments); }
console.log(f(1, 2, 33));

const arr2 = Array.from([1, 2, 3], x => x + 1);

const arr3 = Array(10);

const arr4 = Array(10).fill(0);

const arr5 = Array.from(
  {length: 20},             // 유사배열 (길이 20짜리 배열로 인식함)
  () => Array(10).fill(0)   // 각각의 배열에 적용할 함수
);

// console.log(arr5);
