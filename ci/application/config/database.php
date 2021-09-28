<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => 'root',
	'database' => 'opentutorials',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


/*

<생활코딩 실습위한 생성쿼리>
CREATE DATABASE opentutorials CHARACTER SET utf8 COLLATE utf8_general_ci;
use opentutorials;
CREATE TABLE topic (
    id  int(11) NOT NULL AUTO_INCREMENT,
    title  varchar(255) NOT NULL ,
    description  text NULL ,
    created  datetime NOT NULL ,
    PRIMARY KEY (id)
);

INSERT INTO `topic` (title,description,created) VALUES ('JavaScript란', '<h2>\r\n    자바스크립트는</h2>\r\n<ul>\r\n  <li>\r\n      브라우저에서 실행되는 언어</li>\r\n   <li>\r\n      가장 많이 사용되는 언어</li>\r\n    <li>\r\n      주로 html을 프로그래밍적으로 조작하기 위해서 사용됨</li>\r\n</ul>\r\n<h2>\r\n  예제</h2>\r\n<ul>\r\n <li>\r\n      자바스크립트는 3가지 방식으로 사용됨</li>\r\n <li>\r\n      외부의 파일을 로드</li>\r\n   <li>\r\n      &lt;script&gt;태그 사이에 기술</li>\r\n  <li>\r\n      태그에 직접 기술</li>\r\n</ul>\r\n<h2>\r\n   참고링크</h2>\r\n<ul>\r\n   <li>\r\n      <a href=\"http://www.maroon.pe.kr/webmaster/java/java_study.html\" target=\"_blank\">스크립트 세상</a></li>\r\n <li>  \r\n</ul>\r\n', now());
INSERT INTO `topic` (title,description,created) VALUES ('변수와 상수', '<p>\r\n    변수란</p>\r\n<ul>\r\n <li>\r\n      변하는 값</li>\r\n    <li>\r\n      x = 10 일 때 왼쪽항인 x는 오른쪽 항인 10에 따라 다른 값이 지정된다.</li>\r\n</ul>\r\n<p>\r\n 상수란</p>\r\n<ul>\r\n <li>\r\n      변하지 않는 값</li>\r\n <li>\r\n      x = 10 일 때 오른쪽항인 10이 상수가 된다.</li>\r\n</ul>\r\n<pre class=\"brush: xml\">\r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\n&nbsp;&nbsp;&nbsp; // x의 값이 오른쪽 항에 따라서 변한다.\r\n&nbsp;&nbsp;&nbsp; // x가 변수라는 명시적인 의미\r\n&nbsp;&nbsp;&nbsp; var x = 10;\r\n&nbsp;&nbsp;&nbsp; alert(x);\r\n&nbsp;&nbsp;&nbsp; var x = 20;\r\n&nbsp;&nbsp;&nbsp; alert(x);\r\n&lt;/script&gt;</pre>\r\n<p>\r\n   &nbsp;</p>\r\n', now());
INSERT INTO `topic` (title,description,created) VALUES ('연산자', '<p>\r\n   연산에 사용되는 기호들. (y = 5 일 때)</p>\r\n<table class=\"table\">\r\n    <tbody>\r\n       <tr>\r\n          <th align=\"left\" width=\"15%\">\r\n             Operator</th>\r\n         <th align=\"left\" width=\"40%\">\r\n             Description</th>\r\n          <th align=\"left\" width=\"25%\">\r\n             Example</th>\r\n          <th align=\"left\" width=\"20%\">\r\n             Result</th>\r\n       </tr>\r\n     <tr>\r\n          <td valign=\"top\">\r\n               +</td>\r\n            <td valign=\"top\">\r\n               더하기</td>\r\n          <td valign=\"top\">\r\n               x=y+2</td>\r\n            <td valign=\"top\">\r\n               x=7</td>\r\n      </tr>\r\n     <tr>\r\n          <td valign=\"top\">\r\n               -</td>\r\n            <td valign=\"top\">\r\n               빼기</td>\r\n           <td valign=\"top\">\r\n               x=y-2</td>\r\n            <td valign=\"top\">\r\n               x=3</td>\r\n      </tr>\r\n </tbody>\r\n</table>\r\n', now());
INSERT INTO `topic` (title,description,created) VALUES ('JSON', '<h2>JSON이란?</h2>\r\n\r\n<p>서로 다른 언어들간에 데이터를 주고 받는 여러 방법이 있다. 대표적인 것이 XML인데, XML은 문법이 복잡하고, 엄격한 표현규칙으로 인해서 json 대비 데이터의 용량이 커진다는 단점이 있다.</p>\r\n\r\n<p>JSON은 경량의 데이터 교환 형식으로 JavaScript에서 숫자와 배열등을 만드는 형식을 차용해서 이것을 다른 언어에서도 사용할 수 있도록 한 텍스트 형식이다.&nbsp;</p>\r\n\r\n<p>아래 예제는 위의 예제에서 전송한 데이터를 받아서 몇가지 부가정보를 추가해서 json으로 인코드한 후에 다시 반환하는 PHP 코드다.&nbsp;</p>\r\n\r\n<p>json.php - (<a href=\"https://github.com/egoing/codingeverybody_javascript/blob/master/JSON/json.php\" target=\"_blank\">github</a>)</p>\r\n\r\n<pre class=\"brush: php\">\r\n&lt;?php\r\n$userinfo = json_decode($_GET[&#39;data&#39;]);\r\n$userinfo-&gt;address = &#39;seoul&#39;;\r\n$userinfo-&gt;phonenumber = &#39;01023456789&#39;;\r\necho json_encode($userinfo);\r\n?&gt;</pre>\r\n\r\n<h2>json의 형식</h2>\r\n\r\n<h3>object</h3>\r\n\r\n<p>객체는 아래와 같은 문법을 가지고 있다.</p>\r\n\r\n<p>예제</p>\r\n\r\n<p>{&quot;userid&quot;:&quot;egoing&quot;,&quot;pwd&quot;:&quot;12345567&quot;}</p>\r\n\r\n<p><img height=\"113\" src=\"http://www.json.org/object.gif\" width=\"598\" /></p>\r\n\r\n<h3>array</h3>\r\n\r\n<p>배열은 아래와 같은 문법을 가지고 있다.&nbsp;</p>\r\n\r\n<p>예제</p>\r\n\r\n<p>[1,2,3,4]</p>\r\n\r\n<p><img height=\"113\" src=\"http://www.json.org/array.gif\" style=\"line-height: 1.8em;\" width=\"598\" /></p>\r\n\r\n<h3>Value</h3>\r\n\r\n<p>위에서 사용된 Value는 값을 의미하는데&nbsp;큰 따옴표로 묶인 문자나 숫자, 불린 값이 사용된다.</p>\r\n\r\n<p>예제</p>\r\n\r\n<ul>\r\n  <li>문자 : &quot;헬로우 월드&quot;</li>\r\n    <li>숫자 : 1</li>\r\n <li>불린 : true</li>\r\n</ul>\r\n\r\n<p><img height=\"278\" src=\"http://www.json.org/value.gif\" width=\"598\" /></p>\r\n', now());

SELECT * FROM topic;

*/
