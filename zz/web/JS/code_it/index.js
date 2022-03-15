

console.log('Hello Codeit! 새로운 시작. 22/03/03')

// 세미콜론(;) : 문장을 구분하기 위해 사용
// - 자바스크립트는 한줄에 한문장씩 작성할 경우엔 코드가 실행될 때 자동으로 ;을 추가해준다.
//   하지만 문장끝엔 ;을 써주는게 좋다.
console.log('a');console.log(1);console.log('2')



// 자료형 (Data Type)
console.log('===========================================================  number');

// 숫자형 (number)
// 사칙연산 (연산기호 앞뒤로 띄우는 건 가독성을 위해 암묵적으로 지키는 것이라 함)
// 우선순위 ( () > ** > *, / > +, - )
console.log(1 + 5);
console.log(4 / 2);  // 2
console.log(1 / 5);  // 0.2
console.log(7 / 3);  // 2.3333333333333335
const c = Math.trunc(5 / 2);  // 몫 연산 (소수점을 없앰)
console.log(typeof c, c);     // number 2
console.log(0 / 3);  // 0
console.log(3 / 0);  // Infinity
console.log(typeof (3 / 0));   // number
console.log(2 % 5);  // 2   (나머지 연산)
console.log(2 ** 4); // 16  (거듭제곱)
console.log(2 * 3 ** 2);  // 18 (거듭제곱이 곱보다 우선순위라고함 ㄷㄷ)

// 복합 할당 연산자 (Compound assignment operators)
let x;
x += 2;  // x = x + 2;
x %= 2;  // x = x % 2;

// 증가, 감소연산자 (increment / decrement operator)
x = 1;
x++;                // x = x + 1;  // 해당 라인의 코드 실행된 후에 증가됨
console.log(x);     // 2
console.log(x++);   // 2
console.log(x);     // 3
console.log(++x);   // 4           // 증가하고 해당 라인의 코드 실행됨.

console.log('===========================================================  string');

// 문자열 (String)
// 따옴표를 사용하지 않은 문자열은 변수명으로 인식이됨
// 문자열 연산은 +만 있다.
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

// 문자열 반복하기 (python처럼 *연산 안됨)
// repeat(0 ~ 무한대이하 정수값) 메소드를 사용함
console.log('a'.repeat(3));     // aaa
console.log('a'.repeat(0));     //
console.log('a'.repeat(1.5));   // a (정수형으로 내림한 값이 적용)
// console.log('a'.repeat(-1));    // Uncaught RangeError

// 템플릿 문자열 : 일정한 틀, 형식으로 된 문자열
// 백틱 (``)안에 ${}를 사용하여 만든 문자열 틀
// + +연산보다 편하게 문자열과 변수를 동시에 사용할 수 있다.
// + ${표현식}으로 표현식으로는 변수나 연산식, 함수호출을 사용할 수 있다.
// + 즉 그 안은 그냥 console.log(여기에 적는거라고 보면 된다. 문자열을 빠져나오는.)
let num1 = 2;
console.log(`템플릿 문자열 테스트 -> num1:${num1}, num1*5:${num1 * 5}`)
function getTwice(x) {
  return x * 2;
};
console.log(getTwice(50) * 2);   // 200
console.log(`${num1}의 두배는 ${getTwice(num1)}입니다.`);

console.log('===========================================================  boolean');

// 불대수 (Boolean) : 일상적인 논리를 수학적으로 표현한 것, 즉 참과 거짓을 표현하는 자료형
// + JS에선 true와 false로 표현함. 소문자로.
// + 일반 수학의 연산은 +, -, *, /이지만 불 대수의 연산은 AND, OR, NOT이 있는 것임.
console.log(1 > 0);    // true
console.log(1 >= 0);   // true
console.log(1 <= 0);   // false
console.log(3 === 3);  // true
console.log(3 !== 3);  // false
console.log('');
console.log('Codeit' === 'codeit');   // f (자료형까지 비교. 요걸로 주로 사용하33)
console.log('Codeit' == 'codeit');    // f
console.log('Codeit' !== 'Codeit');   // f
console.log(8 == '8');    // t
console.log(8 === '8');   // f
console.log('');

// 논리 연산
// AND : &&, OR : ||, NOT : !
console.log(true && true);    // true
console.log(true && false);   // f
console.log(false && true);   // f
console.log(false && false);  // f
console.log(true || true);    // true
console.log(true || false);   // true
console.log(false || true);   // true
console.log(false || false);  // f
console.log(!true);    // f
console.log(!false);   // true
console.log(!!true);   // true

console.log('===========================================================  null, undefined');

// null(의도적인 없음)과 undefined(처음부터 없음) -> 값이 없다.
// null : 사용하는 값 (의도적으로 비어있음을 표현)
// undefined : 확인하는 값 (값이 없음); null 처럼 의도적으로 표현할 수도 있지만 null과 헷갈리므로 권장하지 않음.
let codeit;
console.log(codeit);              // undefined (선언시 초기값을 넣어주지 않으면 undefined 값을 가지고 있다. )
codeit = null;
console.log(codeit);              // null
console.log(null == undefined);   // true  (값이 없다는 의미는 비슷하지만)
console.log(null === undefined);  // false (자료형은 다르다!)
let cup;
console.log(cup);  // undefined
cup = '우유';
console.log(cup);  // 우유
cup = null;        // 컵을 비움
console.log(cup);  // null
cup = '';
console.log(typeof cup);    // string
// console.log(cup2);  // cup2 is not defined at index.js:342:13

console.log('===========================================================  typeof');

// typeof 연산자 : 어떤 타입인지를 string값으로 출력해줌
console.log(typeof 10);     // number
console.log(typeof 10.2);   // number (js는 소수, 정수 모두 number로 취급)
console.log(typeof '10');   // string
console.log(typeof `abc`);  // string
console.log(typeof false);  // boolean
console.log('');
let name = 'hyuk';
function sayHi() {
  console.log('Hi');
};
console.log(typeof name);   // string
console.log(typeof sayHi);  // function
console.log(typeof 'my' + 'home');  // stringhome (+보다 우선순위다)
console.log(typeof 1 - 3);  // NaN

// 연산자 우선순위
/*
  1) ()
  2) !, typeof
  3) **
  4) *, /, %
  5) +, -
  6) <, <=, >, >=
  7) ==, ===, !=, !==
  8) &&
  9) ||
  10) =
*/

console.log('======================================================  Type Conversion');

// 형 변환(Type Conversion)

// 명시적 형변환
// 함수 String(), Number(), Boolean()을 사용
console.log(Number('1') + 1);   // 2
console.log(Number('문자'))     // NaN
console.log(Number(true));      // 1
console.log(String(1) + '1');   // 11
console.log(typeof String(true));   // string
console.log('');
console.log(Boolean('문자'));    // true
console.log(Boolean(123));       // true
console.log(Boolean(0));         // false
console.log(Boolean(''));        // false
console.log(Boolean(' '));       // true (공백은 true!!)
console.log(Boolean(null));      // false (없거나 비어있거나)
console.log(Boolean(NaN));       // false (0, '', null, NaN -> falsy값이라 불림)
if(0 || '' || null )
  console.log('일로 안오고');
else
  console.log('일로 오겠지');
console.log('');

// 자동 형변환(암묵적 형변환)
// 자바스크립트는 다른 언어와 다르게 자동으로 형변환이 되기도 한다.
console.log('5' - true);        // 4
// 산술연산(+, -, *, /, %, **)
// +에선 숫자 + 숫자문자열의 경우 숫자계산이 아닌 문자열연산이 우선시되고
// 나머지는 Number로 자동형변환 되어 계산된다.
console.log(4 + '1');     // '41'
console.log(4 + true);    // 5
console.log(4 / '2');     // 2
console.log(5 % '3');     // 2
console.log(5 % 'one');   // NaN  (NaN은 어떤값과 연산해도 NaN값이 나옴)
// 비교연산(<, <=, >, >=)
// 산술연산 맹키로 숫자로 자동 형변환되어 계산됨
console.log(4 < '1');     // false
console.log('4' > false); // true
console.log('one' <= 2);  // false (비교가 불가능한 경우 false출력됨)
// 같음 비교연산(===, !==, ==, !=)
// ==, !=는 자동 형변환이 일어나고 ===, !==는 자료형까지 비교하므로 형변환x
// 두 값이 같은지 비교할때는 형변환이 일어나지 않는 ===를 사용해야 안전하다.
console.log(1 === '1');   // false
console.log(1 === true);  // false
console.log(1 == '1');    // true
console.log(1 == true);   // true



console.log('======================================================  variable');

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

// let 없이 변수 선언을 하면 예전 javascript 코드와의 호환성을 위해 동작은 하지만 권장하지 않는다.
// 엄격모드(strict mode)에선 동작하지 않음. 무조건 let을 쓰도록!!
test1 = 77;
console.log(test1); // 77

// 전역객체 (뭔진 잘 모르겠다.)
// 전역으로 변수 설정시 var나 키워드 없이 변수 선언시 전역객체인 window 프로퍼티가 된다.
// 하지만 let은 전역객체 프로퍼티가 아니다.
let namee = "홍길동e";
var name2 = "홍길동2";
name3 = "홍길동3";
console.log(window.namee);  // undefined
console.log(window.name2);  // 홍길동2
console.log(window.name3);  // 홍길동3

// 선언과 호출 그리고 scope
// - 선언을 하면 호이스팅(인터프리터가 변수와 함수의 메모리 공간을 선언 전에 미리 할당하는 것을 의미)이 발생함
//   초기화는 선언 이후에 해줘야한다.
// - scope : 변수의 유효범위, 즉 변수에는 scope가 있다..
//   전역변수는 코드 어디에서나 사용가능한 scope를 지니고 지역변수는 블록문 내에서만 사용가능한 scope를 지님
let let_test = 11;           // 전역변수 (Global Variable) : 블록문 밖에서 선언한 변수
function scope_test() {      // 블록문 (Block Statement)
  // console.log(let_test);  // 11 (아래 두줄 주석시) | Cannot access ~ (주석 해제시, 즉, 내부 선언이후에 호출해야)
  let let_test = 33;         // 지역변수(Local Variable) : 블록문 내에 선언된 변수
  console.log(let_test);
};
scope_test();           // 33 (블록문 내에서 변수 사용시 먼저 지역변수 확인후 전역변수 확인함)
console.log(let_test);  // 11

// var는 선언전에 호출해도 undefined으로 뜨고 애러는 안난다. 재선언하면 덮어씌어진다.
// - var의 경우 호이스팅(메모리 공간 할당)되면서 초기 값이 없으면 자동으로 undefined를 초기값으로 하여 메모리를 할당
//   그래서 var의 경우 선언 전에 해당 변수를 사용하려고 해도 메모리에 해당 변수가 존재하기에 에러가 발생x.
// - var는 함수 레벨 scope로 재선언하면 덮어씌어지게 되는거임 (완전 이해가 가진 않음..)
// console.log(v1); // Uncaught ReferenceError: v1 is not defined (애러나면 아래부분 실행 안됨)
console.log(var1);  // undefined.(애러 안남) hoisting으로 선언되기 전에는 undefined로 초기화됨.
var var1 = 10;
console.log(var1);  // 10
var1 = 100;
console.log(var1);  // 100
var var1 = 1000;    // 재선언해도 덮어씌어지기에 오류발생해서 감지하는대 애먹을 수 있음
console.log(var1);  // 1000

// let은 선언전에 호출하면 애러발생하고 재선언시에도 애러가 난다.
// - let, const의 경우 호이스팅이 되면서 초기 값이 없다면 var처럼 자동으로 초기값을 할당하지 않음
//   (const의 경우 선언시 초기값을 할당하지 않으면 문법 에러가 납니다).
// - let과 const는 블록 레벨 scope로 동일한 scope 에서는 중복으로 선언할 수가 없숨!
// console.log(let1);  // Uncaught ReferenceError: Cannot access 'let1' before initialization
let let1 = 20;
console.log(let1);  // 20
let1 = 200;
console.log(let1);  // 200
// let let1 = 2000;
// console.log(let1);  // Uncaught SyntaxError: Identifier 'let1' has already been declared

console.log('===========================================================  constant');

// 상수 : 변하지 않는 일정한 값.
// const는 선언시 초기값을 할당하지 않으면 문법애러가 난다. 그리고 추후 값 변경이 불가능함.
// 작명시 카멜표기법이 아닌 스네이크 표기법을 따르며 대문자만 사용해서 변수와 구별한다. (MY_NUMBER)
const PI = 3.14;   // 원주율
let radius = 0;  // 빈값을 넣고 싶을때 자료형이 정해지지 않은 경우는 null로, string이면 ''

function calcArea() {
  return PI * radius * radius;
};
function printArea() {
  return  `반지름이 ${radius}일 때, 원의 넓이는 ${calcArea()}`;
};

radius = 10;
console.log(printArea());   // 반지름이 10일 때, 원의 넓이는 314



console.log('===========================================================  function');

// 함수 : 명령들을 저장하는 박스

// 함수 선언
//  파이썬에선 함수선언후 아래줄에 호출을 해야만 오류가 안나지만
//  자바스크립트에선 함수나 변수 선언시 호이스팅에 의해 함수 선언문이 가장 먼저 실행됩니다.
//  그래서 선언을 호출 아래에 해도 오류가 나진 않지만 보통 선언을 먼저해주고 호출을 함.
function greetings() {
  console.log('Hi');
  console.log('안녕');
  console.log('こんにちは');
  console.log('你好');
};

// 함수 호출
greetings();
greetings();


// Parameter(매개변수)
//  function 함수명(파라미터){
//    console.log(파라미터)
//  }
// 함수이름(인자(값));   -> 함수호출시 값은 파라미터로 들어가 함수내부에서 변수처럼 작동한다.
function welcome(name) {
  console.log('안녕하세요, ' + name + '님!');
};
welcome('혁중');

function printSquare(x) {
  console.log(x * x);
};
printSquare(5);

// 옵셔널 파라미터 (Optional Parameters)
//  파라미터에 기본값을 할당하여 선택적으로(있어도 되고 없어도 되고) 전달을 받음
//  다만 여러 파라미터가 있는경우엔 가장 마지막에 넣어줘야 순서가 밀리지 않음!
function introduce(name, job, nationality = '한국') {
  console.log('제 이름은 ' + name + ' 입니다.');
  console.log('직업은 ' + job + ' 입니다.');
  console.log(`국적은 ${nationality} 입니다.`);
};
introduce('송혁중', '개발자');
introduce('송환중', '레스토랑 오너', '중국');


// prompt : 개신기하군...
function alertTest(num) {
  let var1 = 10;
  alert('당신이 가장 좋아하는 숫자는 ' + num + ' 이군요!');
  alert(`grave를 사용하면 문자열안에서 파라미터인 ${num}, 변수인 ${var1}을 가지고 올수있군!!`)
  alert(`num * var1 = ${num * var1}  // 이렇게 연산식도됨`);
};
// let number = prompt('가장 좋아하는 숫자는 무엇인가요?');
// alertTest(number);


// return : 함수에서 input이 파라미터라면 output은 return을 통해 나온 반환값이다.
//  return은 값을 반환하는 역할도 하고 함수를 종료시키는 역할도 한다.
//  return문이 없는 함수를 실행했을때 log를 찍으면 undefined값이 리턴됨
function getTwice(number) {
  return number * 2;
  console.log('여기는 실행안됨. Dead Code라 함');  // 사용하지 말것.
};
let xx = getTwice(5);
let y = getTwice(2);
console.log(xx * y);

function return_test() {
  console.log('하하');
  return;
}
return_test();    // 하하
console.log(return_test()); // 하하 찍히고 undefined (함수내부에 return;이 없어도 동일)

function localTest() {
  return var2;
}
let var2 = 22;
console.log(localTest());   // var2를 초기화했기에 되긴하지만 파라미터 지정하는게 좋음.



// 제어문
console.log('===========================================================  if');

// if문 (if statement)
let temp = 140;

if(temp <= 0) {
  console.log('얼음 꽁꽁');
}else if(temp < 100) {
  console.log('얼지도 끓지도 않아요~');
}else if(temp < 150) {
  console.log('끓어요');   // 출력됨
}else {
  console.log('다 수증기가 되었어요.');
};

// document.write('<br>이러면 웹페이지에 출력되는군!<br>');
// document.write(1 === 1);
