<?php
header("Content-type: text/html; charset=utf-8");

class Account extends CI_Controller {

   var $id = '';

   function __construct() {
      parent::__construct();
      $this->id = $this->phpsession->get( 'id', 'stc' );
      $this->lv = $this->phpsession->get( 'lv', 'stc' );
      $this->name = $this->phpsession->get( 'name', 'stc' );
      // $this->at = $this->phpsession->get( 'at', 'stc' );
      $this->pg = $this->phpsession->get( 'pg', 'stc' );
      $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
      $this->customerid = $this->phpsession->get( 'customerid', 'stc' );
      $this->load->Model(array('STC_Common', 'STC_mail'));
      $this->load->library('user_agent');
   }

   function index( $referer = null ) {
      $data['login_status'] = "";
      $data['referer'] = $referer;
      $data['login_error'] = "";
      $data['view'] = 'login_view';
      $page = '';
      if($this->agent->is_mobile()){
        $page = "_mobile";
      }
      $this->load->view( 'login_view'.$page, $data );
   }

   //mail 보내주는 함수
   function _sendmail( $to, $fromemail, $subject, $content) {
      $charset='UTF-8';                                    // 문자셋 : UTF-8
      $subject="=?".$charset."?B?".base64_encode($subject)."?=\n";   // 인코딩된 제목
      $header = "MIME-Version: 1.0\n".
            "Content-Type: text/html; charset=".$charset."; format=flowed\n".
            "From: =?utf-8?B?".base64_encode("두리안정보기술센터")."?= <marketing@durianit.co.kr> \n".
            "X-sender : ".$fromemail."\n".
            "X-Mailer : PHP ".phpversion( )."\n".
            "X-Priority : 1\n".
            "Return-Path: ".$fromemail."\n".
            "Content-Transfer-Encoding: 8bit\n";

      return   mail( $to, $subject, $content, $header );
   }

//    //회원리스트
//    function user() {
// //      if( $this->id === null ) {
// //         redirect( 'account' );
// //      }

// //      if( $this->lv != 3 ) {
// //         echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
// //      }

//       $this->load->model('STC_User');

// //      $cur_page = $this->input->get( 'cur_page' );         //   현재 페이지
//       if(isset($_GET['cur_page'])) {
//          $cur_page = $_GET['cur_page'];
//       }
//       else {
//          $cur_page = 0;
//       }                                          //   현재 페이지
//       $no_page_list = 1;                              //   한페이지에 나타나는 목록 개수

//       if(isset($_GET['searchkeyword'])) {
//          $search_keyword = $_GET['searchkeyword'];
//       }
//       else {
//          $search_keyword = "";
//       }
//       $data['search_keyword'] = $search_keyword;

//       if  ( $cur_page <= 0 )
//          $cur_page = 1;

//       $data['cur_page'] = $cur_page;

//       $user_list_data = $this->STC_User->user_list($search_keyword, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
//       $data['count'] = $this->STC_User->user_list_count($search_keyword)->ucount;

//       $data['list_val'] = $user_list_data['data'];
//       $data['list_val_count'] = $user_list_data['count'];

//       $total_page = 1;
//       if  ( $data['count'] % $no_page_list == 0 )
//          $total_page = floor( ( $data['count'] / $no_page_list ) );
//       else
//          $total_page = floor( ( $data['count'] / $no_page_list + 1 ) );         //   전체 페이지 개수

//       $start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
//       $end_page = 0;
//       if  ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) )
//          $end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
//       else
//          $end_page = $total_page;

//       $data['no_page_list'] = $no_page_list;
//       $data['total_page'] = $total_page;
//       $data['start_page'] = $start_page;
//       $data['end_page'] = $end_page;

//       $this->load->view( 'user_list', $data );
//    }

   // //회원리스트에서 회원삭제
   // function user_delete() {
   //    if( $this->id === null ) {
   //       redirect( 'account' );
   //    }

   //    if( $this->lv != "3" ) {
   //       echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
   //    }

   //    $this->load->model('STC_User');
   //    $user_id = $this->input->post( "user_id" );
   //    $this->STC_User->delete_user( $user_id );

   //    echo "<script>alert('삭제되었습니다.');location.href='".site_url()."account/user'</script>";
   // }

   // //회원리스트에서 회원정보 수정뷰
   // function user_view() {
   //    if( $this->id === null ) {
   //       redirect( 'account' );
   //    }

   //    if( $this->lv != "3" ) {
   //       echo "<script>alert('접근할수 없는 메뉴입니다.');location.href='".site_url()."';</script>";
   //    }

   //    $this->load->model( 'User' );

   //    $user_id = $this->input->post( "user_id" );
   //    $userdata = $this->STC_User->selected_user( $user_id );

   //    $data['user_id'] = $userdata['user_id'];
   //    $data['user_name'] = $userdata['user_name'];
   //    $data['user_passwd'] = $userdata['user_passwd'];
   //    $data['restarea_name'] = $userdata['restarea_name'];
   //    $data['user_tel'] = $userdata['user_tel'];
   //    $data['user_email'] = $userdata['user_email'];
   //    $data['user_level'] = $userdata['user_level'];
   //    $data['user_comment'] = $userdata['user_comment'];

   //    $this->load->view( 'modify_view', $data );
   // }

   //회원가입 뷰
   function join($cnum=0) {
      // $this->load->model( 'STC_User' );
      $cnumdata = $this->STC_Common->selected_cnum($cnum);

      if (!$cnumdata['seq']){
         echo "<script>alert('사업자등록번호 확인없이 회원가입을 못합니다.');location.href='".site_url()."/account'</script>";
      }

      $data['cnum'] = $cnum;
      $data['view'] = 'join_view';
      $this->load->view( 'join_view', $data );
   }

   // //회원가입 뷰
   // function join() {
   //    $data['view'] = 'join_view';
   //    $this->load->view( 'join_view', $data );
   // }

   //사업자번호 뷰(아이디 신규신청/분실신고)
   function cnum_view($type) {
      $data['type'] = $type;
      if($type == 1) {
         $this->load->view( 'cnum_view', $data );
      } else {
         $this->load->view( 'cnum_view2', $data );
      }
   }

   //회원가입처리
   function join_ok() {
      // $this->load->model( 'STC_User' );
      $user_id = $this->input->get('user_id');
      $id_check = $this->STC_Common->check_user_id_exist( $user_id );

      // 이미 회원가입되어 있음
      if($id_check == 1) {
         echo "<script>alert('해당 아이디로 가입되어 있는 회원이 있습니다.\\n\\n다른 아이디로 가입하여 주시기 바랍니다.');history.go(-1);</script>";
         exit;
      }

      $data = array(
         'user_part' => '000',
         'user_id' => $this->input->get('user_id'),
         'user_password' => sha1($this->input->get('user_password')),
         'user_name' => $this->input->get('user_name'),
         'company_name' => $this->input->get('company_name'),
         'company_num' => $this->input->get('company_num'),
         'confirm_flag' => 'N',
         'user_duty' => $this->input->get('user_duty'),
         'user_tel' => $this->input->get('user_tel'),
         'user_email' => $this->input->get('user_email'),
         'insert_date' => date("Y-m-d H:i:s"),
         'update_date' => date("Y-m-d H:i:s")
       );


      $result = $this->STC_Common->insert_user( $data, $mode = 0);

      if($result) {
         echo "<script>alert('입력되었습니다.');location.href='".site_url()."'</script>";
         exit;
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
         exit;
      }
   }

   /*
      로그인 회원정보 수정 뷰
   */
   function modify_view() {
      // $this->load->model( 'STC_User' );

      if( $this->id === null ) {
         redirect( 'account' );
      }

      $user_id = $this->id;
      $userdata = $this->STC_Common->selected_user( $user_id );

      $data['seq'] = $userdata['seq'];
      $data['user_part'] = $userdata['user_part'];
      $data['user_id'] = $userdata['user_id'];
      $data['user_name'] = $userdata['user_name'];
      $data['user_password'] = $userdata['user_password'];
      $data['company_name'] = $userdata['company_name'];
      $data['company_num'] = $userdata['company_num'];
      $data['confirm_flag'] = $userdata['confirm_flag'];
      $data['user_tel'] = $userdata['user_tel'];
      $data['user_email'] = $userdata['user_email'];
      // $data['user_level'] = $userdata['user_level'];
      $data['user_duty'] = $userdata['user_duty'];
      $data['user_comment'] = $userdata['update_date'];
      $data['user_birthday'] = $userdata['user_birthday'];
      $data['sign_realname'] = $userdata['sign_realname'];
      $data['sign_changename'] = $userdata['sign_changename'];

      $this->load->view( 'modify_view', $data );
   }


   /*
      로그인, 회원리스트 회원정보수정 처리
   */
   function modify_ok() {
      // $this->load->model( 'STC_User' );

      $user_passwd = $this->input->get('user_password');
      $company_name = $this->input->get('company_name');
      $user_email = $this->input->get('user_email');
      $user_tel = $this->input->get('user_tel');
      $user_duty = $this->input->get('user_duty');
      $user_birthday = $this->input->get('user_birthday');

      $data = array(
         'user_password' => sha1($user_passwd),
         'company_name' => $company_name,
         'user_tel' => $user_tel,
         'user_email' => $user_email,
         'user_duty' => $user_duty,
         'user_birthday' => $user_birthday,
         'update_date' => date("Y-m-d H:i:s")
       );

      $result = $this->STC_Common->insert_user( $data, $mode = 1, $this->id);

      if($result) {
         echo "<script>alert('수정되었습니다.');location.href='".site_url()."'</script>";
      } else {
         echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
      }
   }

   // 로그인
   function login( $referer = null ) {
      $userid = $this->input->post( 'user_id' );
      $userpassword = $this->input->post( 'user_password' );
      $user_level = '';
      $user_authority='';

      if( $userid == null || $userpassword == null )
         redirect('');
      else {
         $userdata = $this->STC_Common->select_user($userid, sha1($userpassword));         //   해당 ID가 존재하는지와 임시 로그인 상태인지 검사

         if(isset($userdata['user_id'])){

           // $key_pass = $this->db->password;
           $key_pass = "durian12#";
           $key_pass = substr(hash('sha256', $key_pass, true), 0, 32);

           $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
           $encrypted = base64_encode(openssl_encrypt($userpassword, 'aes-256-cbc', $key_pass, 1, $iv));
           $create_key = $this->STC_mail->aes_key($userdata['user_email'], $encrypted);


            $user_level = $userdata['user_part'];
            $biz_lv = substr($userdata['user_part'],0,1);
            $sales_lv = substr($userdata['user_part'],1,1);
            $tech_lv = substr($userdata['user_part'],2,1);
            $admin_lv = substr($userdata['user_part'],3,1);
            $cooperation_yn = $userdata['cooperation_yn'];
            $date = date("Y.m.d_H시i분");

            //   해당 아이디가 존재하는 경우
            $var = array(
              'id'=> $userdata['user_id'],
              'name' => $userdata['user_name'],
              'lv' => $user_level,
              'at' => $user_authority,
              'email' => $userdata['user_email'],
              'cnum' => $userdata['company_num'],
              'group'=>$userdata['user_group'],
              'seq'=>$userdata['seq'],
              'pGroupName'=>$userdata['parentGroupName'],
              'duty'=>$userdata['user_duty'],
              'biz_lv'=>$biz_lv,
              'sales_lv'=>$sales_lv,
              'tech_lv'=>$tech_lv,
              'admin_lv'=>$admin_lv,
              'cooperation_yn'=>$cooperation_yn,
              'login_time'=>$date
            );

            foreach( $var as $k => $v )
               $this->phpsession->save( $k, $v, "stc" );
               setcookie("cookieid", "" ,time()+60*60*24*30, "/");
               if($cooperation_yn == 'N') {
                 echo "<script>location.href='".site_url()."/biz/?login=1'</script>";
               } else {
                 echo "<script>location.href='".site_url()."/tech/tech_board/tech_doc_list?type=Y'</script>";
               }
         } else{                                                   //   해당 ID가 존재하지 않음
            echo "<script>alert('로그인에 실패하였습니다.\\n\\n아이디, 비밀번호를 확인후 로그인해 주시기 바랍니다.');location.href='".site_url()."/account'</script>";
         }
      }
   }

   // 로그아웃
   function logout($referer = null) {
      // $var = array( 'id', 'name', 'lv' , 'at', 'pg','customerid','cooperative_id','timeout');

      // foreach( $var as $v ) {
      //    $this->phpsession->clear( $v, 'stc' );
      // }
      session_destroy();

      echo "<script>location.href='".site_url()."'</script>";
   }

   //협력사 로그인
   function cooperative_login_view( $referer = null ) {
      $data['login_status'] = "";
      $data['referer'] = $referer;
      $data['login_error'] = "";
      $data['view'] = 'login_view';
      $this->load->view( 'cooperative_login_view', $data );
   }

   // 사업자번호 확인체크
   function cnum_check() {
      $cnum = $this->input->get( 'cnum' );
      $type = $this->input->get( 'type' );
      $user_email = $this->input->get( 'user_email' );

      $this->load->model( 'admin/STC_User' );

      if ($type == 1){
         $cnumdata = $this->STC_Common->selected_cnum($cnum);
         if (isset($cnumdata['seq'])){
            echo "<script>alert('사업자등록번호가 확인되었습니다.\\n\\n회원가입을 해주시기 바랍니다.');self.close();opener.location.href='".site_url()."/account/join/".$cnum."'</script>";
         } else {
            echo "<script>alert('사업자등록번호가 존재하지 않습니다.\\n\\n다시 확인해 주시기 바랍니다.');history.go(-1);</script>";
         }
      } else {
         $cnumdata2 = $this->STC_Common->selected_cnum2($cnum, $user_email);
         if ($cnumdata2['seq']){
            //   임시 비번 생성
            $vowels = "aeuyAEUY1";
            $consonants = "bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ2345678";

            $temppassword = "";
            $alt = time() % 2;
            for  ( $i = 0 ; $i < 9 ; $i++ ){
               if  ( $alt == 1 ){
                  $temppassword .= $consonants[(rand() % strlen($consonants))];
                  $alt = 0;
               }
               else{
                  $temppassword .= $vowels[(rand() % strlen($vowels))];
                  $alt = 1;
               }
            }

            //   임시 비번 내역 저장
            $this->STC_Common->save_temp_password( $cnumdata2['user_id'], $temppassword );
            $uid = $cnumdata2['user_id'];

            //   메일 발송
            $to_email = $cnumdata2['user_email'];                           //   받을 사람 email
            $from_email = "marketing@durianit.co.kr";                        //   보내는 사람 email
            $subject = "[두리안정보기술센터]아이디, 패스워드 안내메일입니다.";      //   메일 제목
            $data['user_id'] = $uid;
            $data['user_password'] = $temppassword;
            $content = $this->load->view( 'idpw_email', $data, true );

            $mailresult = $this->_sendmail( $to_email, $from_email, $subject, $content );

            if  ( !$mailresult ){
               echo "<script>alert('이메일 보내기가 실패했습니다.');history.go(-1);</script>";
            }

            echo "<script>alert('사업자등록번호가 확인되었습니다.\\n\\n회원가입시 등록한 이메일로 아이디와 패스워드를 보내드렸습니다.');self.close();opener.location.href='".site_url()."/account'</script>";
         } else {
            echo "<script>alert('사업자등록번호가 존재하지 않습니다.\\n\\n다시 확인해 주시기 바랍니다.');history.go(-1);</script>";
         }
      }
   }

   //고객사 로그인 뷰
   function customer_login() {
      $seq = explode('?',$_SERVER['REQUEST_URI']);
      $seq = base64_decode($seq[1]);
      $seq = str_replace("seq=","",$seq);
      $this->load->Model('tech/STC_tech_doc');
      $data['view_val'] = $this->STC_tech_doc->tech_doc_view($seq);
      $data['view'] = 'customer_login_view';
      $this->load->view('customer_login_view',$data);
   }

   //otp mail 전송
   function customer_otp_send() {
      $data['view'] = 'customer_otp_send';
      $this->load->view( 'customer_otp_send',$data);
   }

   // 기술지원보고서 로그인
   function customer_login2( $referer = null ) {
      $userotp = $this->input->post( 'user_otp' );
      $checkotp = $this->input->post( 'otp' );
      $viewSeq = $this->input->post( 'viewSeq' );
      $loginName = $this->input->post( 'loginName' );
      $loginMail = $this->input->post( 'user_email' );

      if( $userotp == null){
         redirect('');
      }else {
         if($checkotp == $userotp){
            $this->phpsession->save('customerid',$loginMail,"stc");
            $_SESSION['timeout'] = time();
            setcookie("cookieid", "" ,time()+60*10, "/");
            echo "<script>location.href='".site_url()."/tech/tech_board/tech_doc_print_action?".$viewSeq."&login=".$loginName." '</script>";
         }else{
            echo "<script>alert('로그인에 실패하였습니다.\\n\\n인증번호 재발급 후 로그인해 주시기 바랍니다.');history.go(-1);</script>";
         }
      }
   }

   // 협력사 로그인
   function cooperative_login( $referer = null ) {
      $managerYN =  $this->input->post( 'managerYN' );
      $user_email= $this->input->post( 'user_email' );
      $userotp = $this->input->post( 'user_otp' );
      $checkotp = $this->input->post( 'otp' );
      $seq = $this->input->post( 'seq' );

      if( $userotp == null){
         redirect('');
      }else {
         if($checkotp == $userotp){
            $this->phpsession->save('cooperative_id',$user_email,"stc");
            $this->phpsession->save('lv',$managerYN,"stc");
            $_SESSION['timeout'] = time();
            setcookie("cookieid", "" ,time()+60*10, "/");
            if($seq == null){
               echo "<script>location.href='".site_url()."/tech/tech_board/request_tech_support_list'</script>";
            }else{
               echo "<script>location.href='".site_url()."/tech/tech_board/request_tech_support_view?seq={$seq}&mode=view'</script>";
            }
         }else{
            echo "<script>alert('로그인에 실패하였습니다.\\n\\n인증번호 재발급 후 로그인해 주시기 바랍니다.');history.go(-1);</script>";
         }
      }
   }

   //정기점검
   function periodic_inspection(){
      // $this->load->model( 'STC_User' );
      $data['group'] = $this->input->get('group');
      $data['view_val']=$this->STC_Common->periodic_inspection($data['group']);
      $this->load->view( 'periodic_inspection', $data );
   }

  function sign_upload() {
    $seq = $this->input->post('seq');
    $sign_password = $this->input->post('sign_password');

    if($_FILES['u_file']) {
      $cname = $_FILES['u_file']['name'];
      $ext = substr(strrchr($cname,"."),1);
      $ext = strtolower($ext);

      $upload_dir = "/var/www/html/stc/misc/upload/user_sign";
      // $upload_dir = "C:/xampp/htdocs/biz/misc/upload/user_sign";
      $conf_file['upload_path'] = $upload_dir;
      $conf_file['allowed_types'] = '*';
      $conf_file['overwrite']  = false;
      $conf_file['encrypt_name']  = true;
      $conf_file['remove_spaces']  = true;

      $this->load->library('upload', $conf_file );
      $result = $this->upload->do_upload('u_file');
      if($result) {
          $file_data = array('upload_data' => $this->upload->data());
          $file_realname = $file_data['upload_data']['orig_name'];
          $file_changename = $file_data['upload_data']['file_name'];

          $data = array(
            'sign_changename' => $file_changename,
            'sign_realname'   => $file_realname,
            'sign_password'   => sha1($sign_password)
          );
          $result = $this->STC_Common->insert_user( $data, $mode = 1, $this->id);
          echo json_encode(true);
      } else {
          echo json_encode(false);
          exit;
      }
    }
  }
}
?>
