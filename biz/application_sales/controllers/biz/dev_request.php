<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class dev_request extends CI_Controller {

   var $id = '';

   function __construct() {
      parent::__construct();
      $this->id = $this->phpsession->get( 'id', 'stc' );
      $this->name = $this->phpsession->get( 'name', 'stc' );
      $this->lv = $this->phpsession->get( 'lv', 'stc' );
      $this->load->library('user_agent');
      $this->group = $this->phpsession->get( 'group', 'stc' ); // 로그인하면 내가 속한 그룹으로 나뉨 -> group이 기술연구소일때 개발진행상황 수정가능하게
      $this->pGroupName = $this->phpsession->get( 'pGroupName', 'stc' );
      $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

      if($this->cooperation_yn == 'Y') {
        echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
      }
      // 모델 호출
      $this->load->Model(array('STC_Common', 'biz/STC_dev_request'));
   }

  function dev_request_list() {
    if($this->id === null) {
      redirect('account');
    }

    if(isset($_GET['cur_page']) && $_GET['cur_page'] != '') {
      $cur_page = $_GET['cur_page'];
    } else {
      $cur_page = 1;
    }

    if(!isset($_GET['lpp']) || $_GET['lpp'] == '') {
      $no_page_list = 10;
    } else {
      $no_page_list = (int)$_GET['lpp'];
    }

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		} else {
			$search_keyword = "";
		}

		if(isset($_GET['search1'])) {
			$search1 = $_GET['search1'];
		} else {
			$search1 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search1'] = $search1;
		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;
    $data['lpp'] = $no_page_list;

		$data['list_val'] = $this->STC_dev_request->dev_request_list($search_keyword,  $search1, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_dev_request->dev_request_list_count($search_keyword, $search1)->ucount;

		$total_page = 1;
		if  ( $data['count'] % $no_page_list == 0 )
			$total_page = floor( ( $data['count'] / $no_page_list ) );
		else
			$total_page = floor( ( $data['count'] / $no_page_list + 1 ) );			//	전체 페이지 개수

		$start_page =  floor(($cur_page - 1 ) / 10) * 10  + 1 ;
		$end_page = 0;
		if  ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) )
			$end_page = ( floor( ( $cur_page - 1 ) / 10 ) + 1 ) * 10;
		else
			$end_page = $total_page;

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

    $this->load->view('biz/dev_request/dev_request_list', $data);
  }

function dev_request_input() {
  if( $this->id === null ) {
    redirect( 'account' );
  }
  $this->load->view('biz/dev_request/dev_request_input');
}

//개발 요청사항 입력/수정 처리
function dev_request_input_action() {
  if( $this->id === null ) {
    redirect( 'account' );
  }
  $this->load->Model( 'STC_dev_request' );
  $seq = $this->input->post('seq');

  $category = $this->input->post('category_code');
  $subject = $this->input->post('subject');
  $progress_step = "접수대기";
  $contents = $this->input->post('contents');
  $page_url = $this->input->post('page_url');
  $type = $this->input->post('type');
  $insert_id = $this->name;
  $file_realname = $this->input->post('file_realname');
  $file_changename = $this->input->post('file_changename');

// 파일업로드
  $file_count = $_POST['file_length'];
  if($type == 1) {
      $file_realname='';
      $file_changename='';
  } else {
      $file_realname = $_POST['file_realname'];
      $file_changename = $_POST['file_changename'];
  }

  if($file_count > 0) {
    for ($i=0; $i<$file_count; $i++) {
      $f = "files".$i;
      $cname = $_FILES[$f]["name"];
      $ext = substr(strrchr($cname,"."),1);
      $ext = strtolower($ext);
      $upload_dir = "/var/www/html/stc/misc/upload/biz/dev_request"; //패치시 변경할 경로
      // $upload_dir = "C:/xampp/htdocs/biz/misc/upload/biz/dev_request";
      $conf_file['upload_path'] = $upload_dir;
      $conf_file['allowed_types'] = '*';
      $conf_file['overwrite']  = false;
      $conf_file['encrypt_name']  = true;
      $conf_file['remove_spaces']  = true;

      $this->load->library('upload', $conf_file );
      $result = $this->upload->do_upload($f);
      if($result) {
          $file_data = array('upload_data' => $this->upload->data());
          $file_realname .= '*/*'.$file_data['upload_data']['orig_name'];
          $file_changename .= '*/*'.$file_data['upload_data']['file_name'];
      } else {
          alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
          echo json_encode(false);
          exit;
      }
    }
    $file_realname = trim($file_realname,'*/*');
    $file_changename = trim($file_changename,'*/*');
  }

  $data = array(
    'category'        => $category,
    'subject'         => addslashes($subject),
    'page_url'        => $page_url,
    'contents'        => $contents,
    'progress_step'   => $progress_step,
    'file_changename' => $file_changename,
    'file_realname'   => $file_realname,
    'insert_id'       => $this->id
  );

    if($seq == null) {
      $data['insert_date'] = date('Y-m-d H:i:s');
      $result = $this->STC_dev_request->dev_request_insert($data, $mode = 0);
    } else {
      $result = $this->STC_dev_request->dev_request_insert($data, $mode = 1, $seq);
    }
    if($result) {
  			echo json_encode(true);
  	} else {
  		echo json_encode(false);
  	}

  }

  // 기술연구소 수정사항 추가 및 수정
    function dev_lab_input_action(){
      if( $this->id === null ) {
        redirect( 'account' );
      }

      $this->load->Model( 'STC_dev_request' );
      $seq = $this->input->post('seq');

      $progress_step = $this->input->post('progress_step');
      $responsibility = $this->input->post('responsibility');
      $start_date = $this->input->post('start_date');
      $expected_end_date = $this->input->post('expected_end_date');
      $contents = $this->input->post('contents');

      // 파일업로드
        $file_count = $_POST['file_length'];
        if($type == 1) {
            $file_realname='';
            $file_changename='';
        } else {
            $file_realname = $_POST['file_realname'];
            $file_changename = $_POST['file_changename'];
        }

        if($file_count > 0) {
          for($i=0; $i<$file_count; $i++) {
            $f = "files".$i;
            $cname = $_FILES[$f]["name"];
            $ext = substr(strrchr($cname,"."),1);
            $ext = strtolower($ext);
            $upload_dir = "/var/www/html/stc/misc/upload/biz/dev_request"; //패치시 변경할 경로
            // $upload_dir = "C:/xampp/htdocs/biz/misc/upload/biz/dev_request";
            $conf_file['upload_path'] = $upload_dir;
            $conf_file['allowed_types'] = '*';
            $conf_file['overwrite']  = false;
            $conf_file['encrypt_name']  = true;
            $conf_file['remove_spaces']  = true;

            $this->load->library('upload', $conf_file );
            $result = $this->upload->do_upload($f);
            if($result) {
                $file_data = array('upload_data' => $this->upload->data());
                $file_realname .= '*/*'.$file_data['upload_data']['orig_name'];
                $file_changename .= '*/*'.$file_data['upload_data']['file_name'];
            } else {
                alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
                echo json_encode(false);
                exit;
            }
          }
          $file_realname = trim($file_realname,'*/*');
          $file_changename = trim($file_changename,'*/*');
        }

      $data = array(
        'dev_request_seq'   => $seq,
        'responsibility'    => $responsibility,
        'start_date'        => $start_date,
        'expected_end_date' => $expected_end_date,
        'contents'          => $contents
      );

      // 개발진행 update
      $pro_data = array(
        'progress_step'     => $progress_step,
        'file_changename' => $file_changename,
        'file_realname'   => $file_realname
      );

      $cnt = $this->STC_dev_request->dev_request_lab_check($seq); //등록/수정 구분

      if($cnt['cnt'] == 0) {
        $result = $this->STC_dev_request->dev_request_lab_insert($data, $mode = 0);
        $result = $this->STC_dev_request->progress_step_insert($pro_data, $seq);
      } else {
        $result = $this->STC_dev_request->dev_request_lab_insert($data, $mode = 1, $seq);
        $result = $this->STC_dev_request->progress_step_insert($pro_data, $seq);
      }
      if($result) {
          echo json_encode(true);
      } else {
        echo json_encode(false);
      }

    }

  function dev_request_view(){
    if( $this->id === null ) {
      redirect( 'account' );
    }
    $seq = $this->input->get('seq');

    $data['view_val'] = $this->STC_dev_request->dev_request_view($seq);
    $data['view_detail_val'] = $this->STC_dev_request->dev_request_view_detail($seq);
    $data['clist_val']    = $this->STC_dev_request->comment_list($seq);

    $this->load->view('biz/dev_request/dev_request_view', $data);
  }

  // 첨부파일 다운로드
  function attachment_download($seq, $filelcname) {
    $this->load->helper('alert');
    $this->load->helper('download');

    ini_set('memory_limit', '200M'); // 김수성 수정 2017-01-04

    $fdata = $this->STC_dev_request->file_check($seq, $filelcname);

    if(!isset($fdata['file_changename'])) {
      alert("파일 정보가 존재하지 않습니다.");
    }

    $data = file_get_contents("/var/www/html/stc/misc/upload/biz/dev_request/".$fdata['file_changename']); //패치시 변경할 경로
    // $data = file_get_contents("C:/xampp/htdocs/biz/misc/upload/biz/dev_request/".$fdata['file_changename']);

    if(!force_download(urlencode($fdata['file_realname']), $data)) {
      alert('파일을 찾을 수 없습니다.');
    }
  }

  function dev_request_modify() {
    if( $this->id === null ) {
      redirect( 'account' );
    }
    $seq = $this->input->get('seq');

    $data['view_val'] = $this->STC_dev_request->dev_request_view($seq);
    $data['view_detail_val'] = $this->STC_dev_request->dev_request_view_detail($seq);

    if($this->pGroupName == "기술연구소"){
      $this->load->view('biz/dev_request/dev_request_modify_lab', $data);
    } else {
      $this->load->view('biz/dev_request/dev_request_modify', $data);
    }
  }

  function dev_delete_action() {
  	if( $this->id === null ) {
  		redirect( 'account' );
  	}

  	$seq = $this->input->post('seq');

  	$result = $this->STC_dev_request->dev_request_delete($seq);
    $result = $this->STC_dev_request->dev_lab_delete($seq);

  	if($result) {
  		echo "<script>alert('정상적으로 삭제되었습니다.');location.href='".site_url()."/biz/dev_request/dev_request_list';</script>";
  	} else {
  		echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
  	}
  }

  function insert_comment() {
  	if( $this->id === null ) {
  		redirect( 'account' );
  	}

  	$data = array(
  		'dev_request_seq' => $this->input->post('seq'),
  		'writer'          => $this->id,
  		'contents'        => $this->input->post('comment'),
  		'insert_date'     => date('Y-m-d H:i:s')
  	);

  	$result = $this->STC_dev_request->insert_comment($data);

  	if($result) {
  		echo "<script>alert('정상적으로 처리되었습니다.');history.go(-1);</script>";
  	} else {
  		echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
  	}
  }

  function delete_comment() {
  	if( $this->id === null ) {
  		redirect( 'account' );
  	}

  	$this->load->helper('alert');
  	$cseq = $this->input->post( 'cseq' );

  	$result = $this->STC_dev_request->delete_comment($cseq);

  	if ($result) {
  		echo "<script>alert('삭제완료 되었습니다.');history.go(-1);</script>";
  	} else {
  		alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
  	}
  }

}
?>
