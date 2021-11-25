
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h4>비교연산자(Comparison Operators) &amp; boolean</h4>
    <?php
    echo '# var_dump -> 데이터타입까지 출력. 문자열은 길이까지<br>';
    var_dump(11);      // int(11)처럼 데이터타입까지 출력함.
    var_dump("bb ");   // string(3) "bb "
    echo '<br><br>';

    echo '# 비교연산자<br>';
    var_dump(1==1);    // bool(true)
    var_dump(1===1);   // 데이터타입까지 비교함
    echo (1==1);        // 1
    echo (1==2)=="";    // 1
    var_dump(1==2);     // bool(false)
    echo '<br><br>';
    $test = imap_utf7_encode("임시 보관함");
    echo $test.'<br>';

    echo '# isset() -> ()안의 값이 없으면 false<br>';
    $var = '';
    $foo = NULL;
    var_dump(isset($var));          // bool(true)
    var_dump(isset($foo));          // bool(false)
    var_dump(isset($var, $foo));    // bool(false)
    echo '<br>';

    $var2 = 'a';
    var_dump(isset($var, $var2));   // bool(true)
    unset ($var2);
    var_dump(isset($var2));         // bool(false)
    // echo $var2;                     // Undefined variable
     ?>
  </body>
</html>
