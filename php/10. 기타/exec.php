<?php

  // exec : 외부프로그램을 실행시켜주는 함수
  //        리눅스에 php가 설치된 경우 쉘명령어들을 사용할 수 있고
  //        (윈도우에 설치된 경우 cmd창에서 실행하는 명령어들을 사용할 수 있다.)

  // string exec ( string $command [, array &$output [, int &$return_var ]] )
  // exec([명령어], [출력값 변수], [결과 변수]);
  // &$output     - 배열 형식으로 모든 결과 해당 포인터 변수에 저장된다.
  // &$return_var - 리눅스 에러발생시 에러 코드 출력


  // 윈도우 cmd창 명령어 실행결과 가져오기 (&&는 다중 명령어 실행시 필요)
  exec("cd C:\Users\go_go\Desktop && dir /w", $output, $return_var);

  echo '$output: <br>';
  foreach($output as $i => $v) {
    echo $i.' -> '.iconv('EUC-KR', 'UTF-8', $v).'<br>';
  }
  echo '<br> $return_var: '.$return_var;

  // 리눅스상에서 리눅스 명령어 실행결과 가져오기 완료 (서버에서 실행되야함)
  // exec("cd /home && ls -al", $output, $error);
  // exec("cd /home && sudo mkdir test1", $output, $error);
  // exec("sudo cd /home/vmail && ls -al", $output, $error);
  // echo '<pre>';
  // var_dump($output);
  // echo '</pre>';
  // echo $error;


  // 애러코드
  #define	EPERM		 1	/* Operation not permitted */
  #define	ENOENT		 2	/* No such file or directory */
  #define	ESRCH		 3	/* No such process */
  #define	EINTR		 4	/* Interrupted system call */
  #define	EIO		 5	/* I/O error */
  #define	ENXIO		 6	/* No such device or address */
  #define	E2BIG		 7	/* Argument list too long */
  #define	ENOEXEC		 8	/* Exec format error */
  #define	EBADF		 9	/* Bad file number */
  #define	ECHILD		10	/* No child processes */
  #define	EAGAIN		11	/* Try again */
  #define	ENOMEM		12	/* Out of memory */
  #define	EACCES		13	/* Permission denied */
  #define	EFAULT		14	/* Bad address */
  #define	ENOTBLK		15	/* Block device required */
  #define	EBUSY		16	/* Device or resource busy */
  #define	EEXIST		17	/* File exists */
  #define	EXDEV		18	/* Cross-device link */
  #define	ENODEV		19	/* No such device */
  #define	ENOTDIR		20	/* Not a directory */
  #define	EISDIR		21	/* Is a directory */
  #define	EINVAL		22	/* Invalid argument */
  #define	ENFILE		23	/* File table overflow */
  #define	EMFILE		24	/* Too many open files */
  #define	ENOTTY		25	/* Not a typewriter */
  #define	ETXTBSY		26	/* Text file busy */
  #define	EFBIG		27	/* File too large */
  #define	ENOSPC		28	/* No space left on device */
  #define	ESPIPE		29	/* Illegal seek */
  #define	EROFS		30	/* Read-only file system */
  #define	EMLINK		31	/* Too many links */
  #define	EPIPE		32	/* Broken pipe */
  #define	EDOM		33	/* Math argument out of domain of func */
  #define	ERANGE		34	/* Math result not representable */



 ?>
