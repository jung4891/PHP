
console.log('Hello Codeit! 새로운 시작. 22/03/03')

// 세미콜론(;) : 문장을 구분하기 위해 사용
// - 자바스크립트는 한줄에 한문장씩 작성할 경우엔 코드가 실행될 때 자동으로 ;을 추가해준다.
//   하지만 문장끝엔 ;을 써주는게 좋다.
console.log('a');console.log(1);console.log('2')

// ====================================================================================

// 자료형 (Data Type)

// 숫자형 (number)
// 사칙연산 (연산기호 앞뒤로 띄우는 건 가독성을 위해 암묵적으로 지키는 것이라 함)
// 우선순위 ( () > ** > *, / > +, - )
console.log(1 + 5);
console.log(1 / 5);  // 0.2
console.log(4 / 2);  // 2
console.log(7 / 3);  // 2.3333333333333335
const c = Math.trunc(5 / 2);  // 몫 연산 (소수점을 없앰)
console.log(typeof c, c);     // number 2
console.log(2 % 5);  // 2   (나머지 연산)
console.log(2 ** 4); // 16  (거듭제곱)
console.log(2 * 3 ** 2);  // 18 (거듭제곱이 곱보다 우선순위라고함 ㄷㄷ)

// 문자열 (String)
// 따옴표를 사용하지 않은 문자열은 변수명으로 인식이됨
// 아래 3개중 어떤걸 사용하든 크게 성능차이는 없다고 함. 다만 가독성을 위해 ', "를 권장.
// + 즉, 안에 따옴표 표시를 할때는 백틱을, 보통때는 편하게 ''를 쓰면 됨
console.log('test1');
console.log("test2");
console.log(`test3`);
console.log('test "1", `2`');
console.log(`test '1', "2"`);
console.log('1'+'2');   // 12
console.log(1+'2');     // 12
console.log('1'+2);     // 12
console.log(1+2+'3');   // 33
console.log('1'+2+3);   // 123
console.log(`1`+(2+3)); // 15

// 따옴표 표시하기
console.log("I'm hyuk.");
console.log('I\'m hyuk.');
console.log('I`m hyuk.');
console.log(`"I'm hyuk"`);  // 아얘 ', " 모두 출력하고 싶으면 백스틱(``) 쓰면 됨

// 줄바꿈하기
console.log("줄바꿈은 \\n을 사용하여 \n이렇게 합니다.");

// 불대수 (Boolean) : 일상적인 논리를 수학적으로 표현한 것, 즉 참과 거짓을 표현하는 자료형
// + JS에선 true와 false로 표현함. 소문자로.
// + 일반 수학의 연산은 +, -, *, /이지만 불 대수의 연산은 AND, OR, NOT이 있는 것임.

// ====================================================================================

// 변수 : 값을 저장하는 박스
let a;
a = 10;
let b = 20;
console.log(a+b);
let $a = 100;
console.log($a);


// 변수명 작명법
// - JavaScript 식별자는 문자(a-z, A-Z), 밑줄(_), $로 시작하고 두번째 글자부터 숫자(0-9)도 가능함.
// - 예약어(JavaScript가 찜해놓은 단어) 사용 불가 -> if, for, let 등
// - 보통 프로그래밍 언어는 대소문자 구분을 한다. (case sensitive)
//   그래서 변수명이 myname와 myName은 다른 변수명으로 인식을 하게 된다. (x) Console.log('test')
// - 보통 기본적으로 소문자를 쓰되 여러 단어로 구성될 경우에
//   JS는 camelCase방식(penPrice) / Python은 underscore방식(pen_price)을 관습처럼 쓴다.
//   언어마다 정해진 "스타일 가이드"가 있다고 한다.


// var, let, const
// - let은 흔히 다른 언어에서 사용하는 변수와 비슷하다.
//   var는 버그 발생과 메모리 누수의 위험등이 있으므로 let, const를 사용하는게 좋다. var는 잊어라.
// - IE 브라우저는 let을 지원하지 않으므로 var를 사용해야한다.
//   babel이라고 let으로 작성해도 var로 지원해주는 컴파일러도 존재하기도 함

function scope_test() {   // 둘다 밖에서 호출시 애러남
  var var_test = "나는 var에요. 밖으로 나갈 수 있어요.";
  let let_test = "나는 let에요. 밖으로 못나가요.";
}

// var는 선언전에 호출해도 undefined으로 뜨고 애러는 안난다. 재선언하면 덮어씌어진다.
// console.log(v1); // Uncaught ReferenceError: v1 is not defined (애러나면 아래부분 실행 안됨)
console.log(var1);  // undefined.(애러 안남) hoisting으로 선언되기 전에는 undefined로 초기화됨.
var var1 = 10;
console.log(var1);  // 10
var1 = 100;
console.log(var1);  // 100
var var1 = 1000;    // 재선언해도 덮어씌어지기에 오류발생해서 감지하는대 애먹을 수 있음
console.log(var1);  // 1000

// let은 선언전에 호출하면 애러발생하고 재선언시에도 애러가 난다.
// console.log(let1);  // Uncaught ReferenceError: Cannot access 'let1' before initialization
let let1 = 20;
console.log(let1);  // 20
let1 = 200;
console.log(let1);  // 200
// let let1 = 2000;
// console.log(let1);  // Uncaught SyntaxError: Identifier 'let1' has already been declared

// let 없이 변수 선언을 하면 예전 javascript 코드와의 호환성을 위해 동작은 하지만 권장하지 않는다.
// 엄격모드(strict mode)에선 동작하지 않음.
test1 = 77;
console.log(test1); // 77

// const는 선언시 초기값을 할당하지 않으면 문법애러가 난다. 그리고 추후 값 변경이 불가능함.
let let2;
let2 = 20;
console.log(let2);
const const1 = 10;
console.log(const1);
// const const2;
// const2 = 10;
// console.log(const2);  // Uncaught SyntaxError: Missing initializer in const declaration

// ====================================================================================

// 함수 : 명령들을 저장하는 박스
// 함수 선언
function greetings() {
  console.log('Hi');
  console.log('안녕');
  console.log('こんにちは');
  console.log('你好');
};
// 함수 호출
greetings();
greetings();

// Parameter (매개변수)
// function 함수이름(P){
//   console.log(P)
// }
// 함수이름(값);   -> 함수호출시 값은 파라미터로 들어가 함수내부에서 변수처럼 작동한다.
function welcome(name) {
  console.log('안녕하세요, ' + name + '님!');
};
welcome('혁중');

function printSquare(x) {
  console.log(x * x);
};
printSquare(5);

function introduce(name, job) {
  console.log('제 이름은 ' + name + ' 입니다.');
  console.log('직업은 ' + job + ' 입니다.');
};
introduce('송혁중', '개발자');

// prompt : 개신기하군...
function alertTest(num) {
  let var1 = 10;
  alert('당신이 가장 좋아하는 숫자는 ' + num + ' 이군요!');
  alert(`grave를 사용하면 문자열안에서 파라미터인 ${num}, 변수인 ${var1}을 가지고 올수있군!!`)
};
// let number = prompt('가장 좋아하는 숫자는 무엇인가요?');
// alertTest(number);

// return : 함수에서 input이 파라미터라면 output은 return을 통해 나온 반환값이다.
function getTwice(number) {
  return number * 2;
};
let x = getTwice(5);
let y = getTwice(2);
console.log(x * y);

function localTest() {
  return var2;
}
let var2 = 22;
console.log(localTest());   // var2를 초기화했기에 되긴하지만 파라미터 지정하는게 좋음.

// ====================================================================================
