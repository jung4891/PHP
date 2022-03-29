

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
console.log(4 - '2');     // 2
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
// var - 재선언 가능, 재할당 가능 (사용 x)
// let - 재선언 불가, 재할당 가능
// const - 재선언 불가, 재할당 불가

// let 없이 변수 선언을 하면 예전 javascript 코드와의 호환성을 위해 동작은 하지만 권장하지 않는다.
// 변수 키워드가 비어있으면 실행과정에서 자동으로 전역변수(var)로 지정해줌.
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



// 제어문
console.log('===========================================================  if');

// if문 (if statement)
// 넓은 범위를 만족하는 조건식을 만들때
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

console.log('===========================================================  switch');

// switch문
// 특정한 값에 일치하는 조건을 만들 때는 if문보다 switch문이 효과적!
// 비교값과 조건값을 비교할때 if에서의 === 연산으로 비교함. 즉 자동형변환 안되므로 '1'은 case '1'이어야함.
// 반복문이 아닌데 break 사용이 가능하고 continue는 사용불가!
let myChoice = 2;

switch(myChoice) {
    case 1:
      console.log('1을 선택하셨습니다.');
      break;
    case 2:
      console.log('2를 선택하셨습니다.');   // 출력됨
    case 3:
      console.log('3을 선택하셨습니다.');   // 출력됨
      break;
    case 4: case 5:
      console.log('4 또는 5를 선택하셨습니다.');  // 여러 조건은 이런식으로 설정!!
      break;
    default:
      console.log('1에서 5사이의 숫자를 선택하세요.');
}



// 반복문 (Loop Statement)
// break : 빠져나옴
// continue : 건너뛴다
console.log('===========================================================  for');

// for문
// for(초기화; 조건; 추가동작) {
//   동작
// }
// 초기화부분에서 생성한 변수는 for문의 로컬변수라서 for문 안에서만 사용할 수 있다.
// for문의 소괄호 안쪽은 반드시 세미콜론 2개가 필요함
for(let i = 1; i <= 3; i++) {
  console.log(`${i} 코드잇 좋아좋아`);   // 1 2 3
}
let i = 10;
for(; i <= 13; i += 2) {
  console.log(`${i} 코드잇 좋아좋아`);   // 10 12
}
for(let i = 100; i <= 103;) {
  console.log(`${i} 코드잇 좋아좋아`);   // 100 102
  i=i+2;
}
// for(;;) {
//   console.log('이렇게 하면 무한반복됨');
// }

console.log('===========================================================  while');

// while문
// 반복문 내부와 밖에서 모두 변수가 사용될때에는 while을 쓰면 좋다.
let j = 1;
while(j <= 3) {
  console.log(`${j} 코드잇 굿`);
  j++;
}
console.log(j);

let k = 1;
while(k <= 5) {
  if(k % 2 === 0) {
    k++;
    continue;
  }
  console.log(k);   // 1 3 5
  k++;
}

// 재귀를 쓰지않은 피보나치 수열 (feat. 이렇게도 되는군 크크);
let aa = 0;
let bb = 1;
for(let i = 1; i <= 10; i++) {
  console.log(bb);
  let tmp = aa;
  aa = bb;
  bb += tmp;
}



console.log('===========================================================  function');

// 함수 : 명령들을 저장하는 박스

// 함수 선언
// - 파이썬에선 함수선언후 아래줄에 호출을 해야만 오류가 안나지만
//   자바스크립트에선 함수나 변수 선언시 호이스팅에 의해 함수 선언문이 가장 먼저 실행됩니다.
//   그래서 선언을 호출 아래에 해도 오류가 나진 않지만 보통 선언을 먼저해주고 호출을 함.
// - 함수명은 대소문자 구별됨!! getName과 getname은 다르다.
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



console.log('===========================================================  object & property ');

// 객체
// 기존 변수에는 값(value)들을 하나만 넣을 수 있었지만 객체에는 여러개(key: value -> 프로퍼티)를 넣을 수 있다.
// 객체의 프로퍼티에는 어떠한 자료형이든 넣을 수 있다. 만능 바구니 느낌?
// 자바스크립트의 모든 것이 다 객체다. 거의 모든 문법에 녹아있다.
// 객체 역시 값이므로 객체를 사용하기 위해선 변수에 넣어서 사용한다.
// 객체안에 객체를 넣을 수도 있다.

// brandName을 key(값이름) 혹은 property name, '코드잇'을 value 혹은 property value라 한다.
// brandName: '코드잇'처럼 key: value 한쌍을 속성(Property)이라 한다.
//  - key는 String타입이지만 따옴표 생략하더라도 문자열로 형변환되기에 일반적으로 생략을 한다.
//    다만, 첫글자는 반드시 문자, _, $중 하나로 시작하고 띄어쓰기와 하이픈(-)은 금지.
//    위 규칙을 벗어나는 경우 따옴표('')로 감싸줘야함!!
//  - value는 당연히 모든 자료형을 사용할 수 있다.

let code_it = {
  brandName: '코드잇',
  'born Year': 2017,
  'isVeryNice': true,
  worstCourse: null,
  bestCourse: {
    title: '자바스크립트 프로그래밍 기초',
    language: 'JavaScript'
  }
}
console.log(code_it);
console.log(typeof code_it);


// 객체의 property에 접근하기

// 1) 점 표기법 (objectName.propertyName) : 일반적으로 주로 사용
console.log(code_it.brandName);         // 코드잇
console.log(code_it.isVeryNice);        // true
console.log(code_it.bestCourse.title);  // 자바스크립트 프로그래밍 기초
console.log(code_it.noProperty);        // undefined (애러나지 않음)

// 2) 대괄효 표기범(objectName['propertyName']) : key의 작명규칙을 벗어난 경우에 사용
// console.log(code_it[brandName]);         // 대괄호 사용시 내부는 String 사용해야함!!!!
console.log(code_it['born Year']);       // 2017
console.log(code_it['born' + ' Year']);  // 2017
let propertyName = 'born Year';
console.log(code_it[propertyName]);      // 2017


// 객체 property 추가/수정/삭제
// delete object.propertyName.
code_it.user = '혁중';
console.log(code_it.user);
code_it.user = '혁중2';
console.log(code_it.user);
delete code_it.user;
console.log(code_it.user);    // undefined (콘솔창에서 바로 code_it치면 console.log맹키로 객체 확인가능)
code_it['blank test'] = '공백 포함되면 이렇게';
console.log(code_it['blank test']);


// 객체의 property 존재여부 확인
// 'propertyName' in object
console.log(code_it.user !== undefined);        // false
console.log(code_it.brandName !== undefined);   // true (존재함)
console.log('brandName' in code_it);            // true
// console.log(brandName in code_it);           // in 연산자를 사용할때는 문자열로!!
if('isVeryNice' in code_it) {
  console.log(`isVeryNice 값은 ${code_it.isVeryNice}입니다.`);   // 출력됨
}else {
  console.log('name 프로퍼티는 존재하지 않음');
}
console.log('');


console.log('===========================================================  object_method ');

// 객체와 메소드
// 연관된 여러값들을 하나로 묶고 싶을때 객체를 활용한 것처럼
// 연관성 있는 여러 함수들을 하나로 묶고 싶을때도 객체를 사용하면 됨.
// 마치 객체는 모든걸 다 담을 수 있는 바구니 같다.
// 이때 프로퍼티 값으로 함수를 넣으면 된다. 이 함수들을 객체의 메소드라 한다.
// 메소드는 객체의 고유한 동작을 수행하는 기능을 담당.
// 마치 클래스의 필드(String name) / 메소드 (void call())와 비슷한것 같다.
// + 함수(function) : 특정 작업을 수행하기 위한 명령어의 집합
//   메소드(method) : 함수인데 객체와 연관된.
let greeting = {
  name: '인사하기',     // ; 아니고 , 써야함 ㅋㅋㅋ
  sayHi: function() {
    console.log('Hello!');
  },
  sayBye: function(name) {
    console.log(`Bye! ${name}!`)
  }
}
console.log(greeting.name);    // 인사하기 (객체의 정보)
greeting.sayHi();              // Hello! (객체의 동작)
greeting['sayHi']();           // Hello!
greeting.sayBye('혁쫑');       // Bye! 혁쫑!
greeting['sayBye']('대괄호');  // Bye! 대괄호!
console.log('이거 역시 console이라는 객체의 log라는 메소드다.');
console['log']('이렇게도 되는군.');

function sayHi() {
  console.log('객체 밖의 함수와 객체 안의 메소드와 이름이 중복되도?');
}
sayHi();  // 되는군.! 결국 메소드는 객체 안에서만 유효하군


// 객체에 메소드를 넣으면 이름 중복도 허용되서 객체만의 고유한 동작들을 정의할 수 있다.
let triAngle = {
  width: 5,
  height: 10,
  getArea: function() {
    return triAngle.width * triAngle.height / 2;
  }
}
let rectAngle = {
  width: 10,
  height: 10,
  getArea: function() {
    return triAngle.width * triAngle.height;
  }
}
let area = triAngle.getArea();
console.log(area + '.');    // 25.
console.log(rectAngle);


console.log('===========================================================  object_for..in ');

// for...in 반복문
// 객체의 property name을 가져오는 반복문으로 일반 for문으로는 객체 프로퍼티에 접근할 수 없다.
// 객체의 property name이 변수로 들어가 프로퍼티 갯수만큼 동작하게 된다
//  for (변수 in 객체) {
//   동작
//  }
for(let key in code_it) {
  console.log(key);           // key 출력됨 (property name)
  console.log(code_it[key]);  // value 출력됨 (perperty value)
}


// 프로퍼티 네임 정렬 주의할점!
// 정수형 프로퍼티 네임을 오름차순으로 정렬하고 나머지 프로퍼티들은 추가한 순서대로 정렬됨!!!
// 그러므로 일반적으로는 정수형 프로퍼티는 잘 사용되지 않는다.
//  + 숫자형(양수)사용시 문자열로 형변환되고 value 접근시 대괄호표기법만 사용가능함
let myObject = {
  10: 10,
  1: '일',
  // -1: '빼기일',   // 음수형은 사용할 수 없음
  '2': '문자2',
  'test1': '테스트1',
  1.1: '일점일',
  '테스트2': '테스트22'
}
console.log(myObject);         // {1: '일', 2: '문자2', 10: 10, test1: '테스트1', 1.1: '일점일', 테스트2: '테스트22'}
// console.log(myObject.10);   // 문자열처럼 점표기법 안됨
console.log(myObject[10]);     // 10
console.log(myObject['1']);    // 일

for(let key in myObject) {
  console.log(key + ' ' + typeof key);                        // 1 string   2 string     10 string   1.1 string
  console.log(myObject[key] + ' ' + typeof myObject[key]);    // 일 string  문자2 string  10 number  1.1 string
}


console.log('===========================================================  object_Date ');

// 내장 객체 (Standard built-in objects)
// console처럼 자바스크립트가 미리 가지고 있는 객체
// '자바스크립트의 모든 것이 다 객체다!' 그래서 다양한 기능을 가진 객체들이 있다.

// Date 객체
// 자바스크립트에서 날짜는 모두 Date 객체로 다룬다!
// Date는 생성자 함수이지만 Date로 만들어진 값은 객체다.
// new Date()는 객체로 다양한 함수들을 사용할 수 있다. Date()는 그냥 함수 (근데 실제로 써먹어봐야 제대로 차이 제대로 알듯)
console.log(typeof Date());       // string
console.log(Date());              // Mon Mar 28 2022 16:16:45 GMT+0900 (한국 표준시)
console.log(typeof new Date());   // object
console.log(new Date());          // Mon Mar 28 2022 16:16:45 GMT+0900 (한국 표준시)

// 시간 넣기 (문자열 방식)
let myDate = new Date();  // Date객체를 생성한 순간의 시각 (즉 지금 이 순간의 시간을 표현하는 객체임)
console.log(myDate);      // Tue Mar 22 2022 22:04:16 GMT+0900 (한국 표준시)
myDate = new Date(1000);  // 70년 1월 1일 0시 0분 0초에서 1초(1000밀리초) 지난 순간의 date 객체 (milliseconds)
console.log(myDate);      // Thu Jan 01 1970 09:00:01 GMT+0900 (한국 표준시)
myDate = new Date('2022-03-22');  // 특정 날짜에 대한 date 객체를 생성할 때는 이렇게함 ('YYYY-MM-DD')
console.log(myDate);              // Tue Mar 22 2022 09:00:00 GMT+0900 (한국 표준시)
myDate = new Date('2022-03-22T22:18:59'); // ('YYYY-MM-DDThh:mm:ss')
console.log(myDate);                      // Tue Mar 22 2022 22:18:59 GMT+0900 (한국 표준시)
myDate = new Date('3/28/2022 16:11:00');  // + ('Dec 15 1999 05:25:30'); ('December 15, 1999 05:25:30');
console.log(myDate);                      // Mon Mar 28 2022 16:11:00 GMT+0900 (한국 표준시)
console.log('');

// 시간 넣기 (여러 파라미터를 활용)
//   new Date(YYYY, MM, DD, hh, mm, ss, ms);
//   YYYY, MM 만 필수!(연도, 월, 1, 0, 0, 0, 0)으로 처리됨
//   MM(월)만 0부터 시작!
myDate = new Date(2022, 2, 26, 17, 50, 0, 2000);
console.log(myDate);    // Sat Mar 26 2022 17:50:02 GMT+0900 (한국 표준시)
myDate = new Date(2022, 2, 26, 17);
console.log(myDate);    // Sat Mar 26 2022 17:00:00 GMT+0900 (한국 표준시)
myDate = new Date(2022, 2, 26);
console.log(myDate);    // Sat Mar 26 2022 00:00:00 GMT+0900 (한국 표준시)
myDate = new Date(2022, 2);
console.log(myDate);    // Tue Mar 01 2022 00:00:00 GMT+0900 (한국 표준시)
myDate = new Date(2022);
console.log(myDate);    // Thu Jan 01 1970 09:00:02 GMT+0900 (한국 표준시) // XXX:
myDate = new Date(2022, 0, 32);   // Date 객체는 범위를 벗어나는 값을 설정하면 자동으로 날짜를 수정해줌
console.log(myDate);              // Tue Feb 01 2022 00:00:00 GMT+0900 (한국 표준시)
console.log('');

// 시간 가져오기 (timestamp)
//   Date.getTime() -> 1970년 1월 1일 00:00:00 UTC부터 몇 밀리초 지났는지 출력해줌 -> 타임스탬프(time stamp)라 함\
//   Date.now() 메소드는 이 메소드가 호출된 시점의 트임스탬프를 반환함. 객체를 만들지 않고도 현시점의 스탬프값을 알 수 있다!
myDate = new Date(2022, 2, 26, 17, 56);
console.log(myDate.getTime());    // 1648284960000
let now = new Date();
let timeDiff = now.getTime() - myDate.getTime();
console.log(timeDiff + '밀리초');                  // 319466밀리초
console.log(timeDiff / 1000 + '초');               // 399.253초
console.log(timeDiff / 1000 / 60 + '분');          // 6.858616666666666분
console.log(timeDiff / 1000 / 60 / 60 + '시간');   // 0.11745194444444444시간
console.log(timeDiff);    // 665739
console.log(now);         // Sat Mar 26 2022 18:07:30 GMT+0900 (한국 표준시)
console.log(now.getTime() === Date.now());   // true
console.log('');

// 시간 가져오기 (구체적인 년월일시각)
//   월과 요일은 0부터 시작!!
console.log(now.getFullYear());   // 2022
console.log(now.getMonth());      // 2 (3월)
console.log(now.getDate());       // 26
console.log(now.getDay());        // 6 (토)
console.log(now.getHours());      // 18
console.log(now.getMinutes());    // 11
console.log(now.getSeconds());    // 21
console.log(now.getMilliseconds()); // 475 (getMilliSeconds 안됨. 즉, 대소문자 주의!!)

// 시간 가져오기 (한꺼번에 간단히 가져오기)
console.log(now.toLocaleDateString());    // 2022. 3. 26.
console.log(now.toLocaleTimeString());    // 오후 6:41:38
console.log(now.toLocaleString());        // 2022. 3. 26. 오후 6:41:51

// Date 객체 정보 수정하기
/*
setFullYear(year, [month], [date])    []는 선택사항
setMonth(month, [date])
setDate(date)
setHours(hour, [min], [sec], [ms])
setMinutes(min, [sec], [ms])
setSeconds(sec, [ms])
setMilliseconds(ms)
setTime(milliseconds)   // timestamp값을 넣어주면 그만큼의 시간이 지난 Date객체로 수정됨
*/
console.log(now);   // Sat Mar 26 2022 18:35:11 GMT+0900 (한국 표준시)
now.setFullYear(2100);
now.setMonth(0);
now.setDate(1);
console.log(now);         // Fri Jan 01 2100 18:36:24 GMT+0900 (한국 표준시)
console.log(new Date());  // Sat Mar 26 2022 18:37:12 GMT+0900 (한국 표준시)
now.setTime(new Date().getTime());
console.log(now);         // Sat Mar 26 2022 18:38:02 GMT+0900 (한국 표준시)

// Date객체의 형변환
myDate = new Date(2022, 3, 28);
console.log(typeof myDate);   // object
console.log(myDate);          // Thu Apr 28 2022 00:00:00 GMT+0900 (한국 표준시)
console.log(String(myDate));  // 동일(타입은 문자열)
console.log(Boolean(myDate)); // true
console.log(Number(myDate) === myDate.getTime());   // true (즉, 숫자형 형변환시 timestamp값이 됨)
let myDate1 = new Date(2022, 3, 29);
timeDiff = myDate1 - myDate;    // 그러므로 Date객체끼리도 바로 사칙연산이 가능해짐
console.log(timeDiff / 1000 / 60 / 60 / 24 + '일');  // 1일



console.log('===========================================================  Array ');

// 배열 (Array)
// - 프로퍼티 네임을 순서로만 혹은 그저 값들을 묶을때는 배열을 사용하는게 효율적.
// - index : 요소별로 각 순서를 나타내주는 숫자. (== propertyName)
// - 배열에서 반복문은 일반적인 for문을 사용하는게 좋다.
//   for...in 반복문은 배열보다는 객체에 적합하게 설계된 반복문이라 배열에 쓸 경우 효율성도 떨어집니다. 
/*
  기존 객체는 이렇게 선언하지만
  let object = {
    course1: '자바스크립트 프로그래밍 기초',
    course2: 'Git으로 배우는 버전 관리',
    course3: '컴퓨터 개론',
    course4: '파이썬 프로그래밍 기초'
  }
*/
// 객체는 대괄호와 ,만으로 표현한다
let courseArray = [
  '자바스크립트 프로그래밍 기초', // 배열안의 각 값들은 요소(element)라 부른다
  'Git으로 배우는 버전 관리',
  '컴퓨터 개론',
  '파이썬 프로그래밍 기초'
];
let menus = ['짜장', '짬뽕', '탕수육'];

// indexing : 인덱스를 통해 요소에 접근하는 것
console.log(courseArray[0]);
console.log(courseArray[1 + 1]);    // 컴퓨터 개론

// 배열도 객체의 한 종류다.
console.log(typeof menus);    // object
let date = new Date();
// date. 을 하면 다양한 메소드들이 나오듯이
// menus. 을 해도 배열 역시 객체이기에 다양한 프로퍼티(p)와 메소드(f)들을 확인할 수 있다.
console.log(menus);
/*
 (3) ['짜장', '짬뽕', '탕수육']
    0: "짜장"
    1: "짬뽕"
    2: "탕수육"
    length: 3
*/

// 배열 다루기
console.log(menus.length);              // 배열의 요소 갯수 출력
console.log(menus['length']);           // 프로퍼티이기에 대괄호 표기법으로도 접근가능하다.
console.log(menus[menus.length - 1]);   // 탕수육 (배열의 마지막 요소에 접근)
console.log(menus[3]);  // undefined
menus[3] = "만두";      // 요소 추가 혹은 수정
console.log(menus[3]);  // 만두
menus[5] = "깐풍기";     // index를 건너뛴뒤 값을 추가하면 그 사이에 empty값이 들어간 요소로 생성되어 length도 +1.
console.log(menus);
/*
(6) ['짜장', '짬뽕', '탕수육', '만두', empty, '깐풍기']
  0: "짜장"
  1: "짬뽕"
  2: "탕수육"
  3: "만두"
  5: "깐풍기"
  length: 6
*/
console.log(menus[4]);    // undefined
delete menus[0];          // 요소가 완전삭제되진 않고 length는 유지된채 empty로 남아있다.
console.log(menus);
/*
(6) [empty, '짬뽕', '탕수육', '만두', empty, '깐풍기']
  1: "짬뽕"
  2: "탕수육"
  3: "만두"
  5: "깐풍기"
  length: 6
*/











//
