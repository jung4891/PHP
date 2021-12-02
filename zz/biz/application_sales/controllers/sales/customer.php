<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Customer extends CI_Controller {

	var $id = '';

	function __construct() {
		parent::__construct();
		$this->id = $this->phpsession->get( 'id', 'stc' );
		$this->name = $this->phpsession->get( 'name', 'stc' );
		$this->lv = $this->phpsession->get( 'lv', 'stc' );
		$this->cnum = $this->phpsession->get( 'cnum', 'stc' );

		$this->load->Model(array('sales/STC_Customer', 'sales/STC_Common'));
	}

	//거래처 리스트(공통)
	function customer_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		}
		else {
			$search_keyword = "";
		}


		$search1 = "";

		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		}
		else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search2'] = $search2;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Customer->customer_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Customer->customer_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

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

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

		$this->load->view( 'sales/customer_list', $data );
	}

	//1. 거래처 기본사항 입력/수정 처리
	function customer_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post('seq');
		$cnum = $this->input->post('cnum');

		if($seq == null) {
			$num_check = $this->STC_Customer->check_num_exist( $cnum );
			if($num_check == 1) {
				echo "<script>alert('해당 사업자번호로 거래처가 등록되어 있습니다.\\n\\n다른 사업자번호로 등록해 주시기 바랍니다.');history.go(-1);</script>";
				exit;
			}
		}

		$filename = NULL;
		$lcfilename = NULL;
		$filename2 = NULL;
		$lcfilename2 = NULL;

		$csize = $_FILES["cnum_file"]["size"];
		$cname = $_FILES["cnum_file"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);

		$bsize = $_FILES["bnum_file"]["size"];
		$bname = $_FILES["bnum_file"]["name"];
		$ext2 = substr(strrchr($bname,"."),1);
		$ext2 = strtolower($ext2);

		if (($csize > 0 && $cname) && ($bsize > 0 && $bname)) {
			if ($csize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}
			if ($bsize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			if($ext2 != "doc" && $ext2 != "docx" && $ext2 != "txt" && $ext2 != "ppt" && $ext2 != "pptx" && $ext2 != "xls" && $ext2 != "xlsx" && $ext2 != "zip" && $ext2 != "rar" && $ext2 != "gif" && $ext2 != "jpg" && $ext2 != "jpeg" && $ext2 != "png" && $ext2 != "pdf" && $ext2 != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//사업자번호 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/basic";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('cnum_file') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			//계좌번호 업로드
			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('bnum_file') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename2 = $data['upload_data']['orig_name'];
				$lcfilename2 = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			$data = array(
				'company_part' => $this->input->post('company_part'),
				'company_form' => $this->input->post('company_form'),
				'company_name' => $this->input->post('company_name'),
				'rnum' => $this->input->post('rnum'),
				'cnum' => $this->input->post('cnum'),
				'perchase_part' => $this->input->post('perchase_part'),
				'represent_name' => $this->input->post('represent_name'),
				'company_category' => $this->input->post('company_category'),
				'company_sector' => $this->input->post('company_sector'),
				'establish_date' => $this->input->post('establish_date'),
				'entry_reason' => $this->input->post('entry_reason'),
				'recommand_name' => $this->input->post('recommand_name'),
				'cnum_flag' => $this->input->post('cnum_flag'),
				'cnum_part' => $this->input->post('cnum_part'),
				'cnumfile_changename' => $lcfilename,
				'cnumfile_realname' => $filename,
				'company_post' => $this->input->post('company_post'),
				'company_addr1' => $this->input->post('company_addr1'),
				'company_addr2' => $this->input->post('company_addr2'),
				'post_post' => $this->input->post('post_post'),
				'post_addr1' => $this->input->post('post_addr1'),
				'post_addr2' => $this->input->post('post_addr2'),
				'represent_tel' => $this->input->post('represent_tel'),
				'represent_handphone' => $this->input->post('represent_handphone'),
				'represent_fax' => $this->input->post('represent_fax'),
				'represent_email' => $this->input->post('represent_email'),
				'local_code' => $this->input->post('local_code'),
				'ccountry_code' => $this->input->post('ccountry_code'),
				'birth_date' => $this->input->post('birth_date'),
				'highschool' => $this->input->post('highschool'),
				'university' => $this->input->post('university'),
				'specialty' => $this->input->post('specialty'),
				'bcountry_code' => $this->input->post('bcountry_code'),
				'bank_code' => $this->input->post('bank_code'),
				'bnum' => $this->input->post('bnum'),
				'bnumfile_changename' =>  $lcfilename2,
				'bnumfile_realname' =>  $filename2,
				'deposit_name' => $this->input->post('deposit_name'),
				'payment_account' => $this->input->post('payment_account'),
				'tax_part' => $this->input->post('tax_part'),
				'user_id' => $this->id,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		} else if (($csize > 0 && $cname) && ($bsize <= 0 )) {
			if ($csize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//사업자번호 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/basic";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('cnum_file') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			$data = array(
				'company_part' => $this->input->post('company_part'),
				'company_form' => $this->input->post('company_form'),
				'company_name' => $this->input->post('company_name'),
				'rnum' => $this->input->post('rnum'),
				'cnum' => $this->input->post('cnum'),
				'perchase_part' => $this->input->post('perchase_part'),
				'represent_name' => $this->input->post('represent_name'),
				'company_category' => $this->input->post('company_category'),
				'company_sector' => $this->input->post('company_sector'),
				'establish_date' => $this->input->post('establish_date'),
				'entry_reason' => $this->input->post('entry_reason'),
				'recommand_name' => $this->input->post('recommand_name'),
				'cnum_flag' => $this->input->post('cnum_flag'),
				'cnum_part' => $this->input->post('cnum_part'),
				'cnumfile_changename' => $lcfilename,
				'cnumfile_realname' => $filename,
				'company_post' => $this->input->post('company_post'),
				'company_addr1' => $this->input->post('company_addr1'),
				'company_addr2' => $this->input->post('company_addr2'),
				'post_post' => $this->input->post('post_post'),
				'post_addr1' => $this->input->post('post_addr1'),
				'post_addr2' => $this->input->post('post_addr2'),
				'represent_tel' => $this->input->post('represent_tel'),
				'represent_handphone' => $this->input->post('represent_handphone'),
				'represent_fax' => $this->input->post('represent_fax'),
				'represent_email' => $this->input->post('represent_email'),
				'local_code' => $this->input->post('local_code'),
				'ccountry_code' => $this->input->post('ccountry_code'),
				'birth_date' => $this->input->post('birth_date'),
				'highschool' => $this->input->post('highschool'),
				'university' => $this->input->post('university'),
				'specialty' => $this->input->post('specialty'),
				'bcountry_code' => $this->input->post('bcountry_code'),
				'bank_code' => $this->input->post('bank_code'),
				'bnum' => $this->input->post('bnum'),
//				'bnumfile_changename' => $this->input->post('bnumfile_changename'),
//				'bnumfile_realname' => $this->input->post('bnumfile_realname'),
				'deposit_name' => $this->input->post('deposit_name'),
				'payment_account' => $this->input->post('payment_account'),
				'tax_part' => $this->input->post('tax_part'),
				'user_id' => $this->id,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		} else if (($bsize > 0 && $bname) && ($csize <= 0 )) {
			if ($bsize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext2 != "doc" && $ext2 != "docx" && $ext2 != "txt" && $ext2 != "ppt" && $ext2 != "pptx" && $ext2 != "xls" && $ext2 != "xlsx" && $ext2 != "zip" && $ext2 != "rar" && $ext2 != "gif" && $ext2 != "jpg" && $ext2 != "jpeg" && $ext2 != "png" && $ext2 != "pdf" && $ext2 != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//사업자번호 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/basic";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('bnum_file') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			$data = array(
				'company_part' => $this->input->post('company_part'),
				'company_form' => $this->input->post('company_form'),
				'company_name' => $this->input->post('company_name'),
				'rnum' => $this->input->post('rnum'),
				'cnum' => $this->input->post('cnum'),
				'perchase_part' => $this->input->post('perchase_part'),
				'represent_name' => $this->input->post('represent_name'),
				'company_category' => $this->input->post('company_category'),
				'company_sector' => $this->input->post('company_sector'),
				'establish_date' => $this->input->post('establish_date'),
				'entry_reason' => $this->input->post('entry_reason'),
				'recommand_name' => $this->input->post('recommand_name'),
				'cnum_flag' => $this->input->post('cnum_flag'),
				'cnum_part' => $this->input->post('cnum_part'),
//				'cnumfile_changename' => $lcfilename,
//				'cnumfile_realname' => $filename,
				'company_post' => $this->input->post('company_post'),
				'company_addr1' => $this->input->post('company_addr1'),
				'company_addr2' => $this->input->post('company_addr2'),
				'post_post' => $this->input->post('post_post'),
				'post_addr1' => $this->input->post('post_addr1'),
				'post_addr2' => $this->input->post('post_addr2'),
				'represent_tel' => $this->input->post('represent_tel'),
				'represent_handphone' => $this->input->post('represent_handphone'),
				'represent_fax' => $this->input->post('represent_fax'),
				'represent_email' => $this->input->post('represent_email'),
				'local_code' => $this->input->post('local_code'),
				'ccountry_code' => $this->input->post('ccountry_code'),
				'birth_date' => $this->input->post('birth_date'),
				'highschool' => $this->input->post('highschool'),
				'university' => $this->input->post('university'),
				'specialty' => $this->input->post('specialty'),
				'bcountry_code' => $this->input->post('bcountry_code'),
				'bank_code' => $this->input->post('bank_code'),
				'bnum' => $this->input->post('bnum'),
				'bnumfile_changename' => $lcfilename,
				'bnumfile_realname' => $filename,
				'deposit_name' => $this->input->post('deposit_name'),
				'payment_account' => $this->input->post('payment_account'),
				'tax_part' => $this->input->post('tax_part'),
				'user_id' => $this->id,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		} else {
			$data = array(
				'company_part' => $this->input->post('company_part'),
				'company_form' => $this->input->post('company_form'),
				'company_name' => $this->input->post('company_name'),
				'rnum' => $this->input->post('rnum'),
				'cnum' => $this->input->post('cnum'),
				'perchase_part' => $this->input->post('perchase_part'),
				'represent_name' => $this->input->post('represent_name'),
				'company_category' => $this->input->post('company_category'),
				'company_sector' => $this->input->post('company_sector'),
				'establish_date' => $this->input->post('establish_date'),
				'entry_reason' => $this->input->post('entry_reason'),
				'recommand_name' => $this->input->post('recommand_name'),
				'cnum_flag' => $this->input->post('cnum_flag'),
				'cnum_part' => $this->input->post('cnum_part'),
				'cnumfile_changename' => $lcfilename,
				'cnumfile_realname' => $filename,
				'company_post' => $this->input->post('company_post'),
				'company_addr1' => $this->input->post('company_addr1'),
				'company_addr2' => $this->input->post('company_addr2'),
				'post_post' => $this->input->post('post_post'),
				'post_addr1' => $this->input->post('post_addr1'),
				'post_addr2' => $this->input->post('post_addr2'),
				'represent_tel' => $this->input->post('represent_tel'),
				'represent_handphone' => $this->input->post('represent_handphone'),
				'represent_fax' => $this->input->post('represent_fax'),
				'represent_email' => $this->input->post('represent_email'),
				'local_code' => $this->input->post('local_code'),
				'ccountry_code' => $this->input->post('ccountry_code'),
				'birth_date' => $this->input->post('birth_date'),
				'highschool' => $this->input->post('highschool'),
				'university' => $this->input->post('university'),
				'specialty' => $this->input->post('specialty'),
				'bcountry_code' => $this->input->post('bcountry_code'),
				'bank_code' => $this->input->post('bank_code'),
				'bnum' => $this->input->post('bnum'),
				'bnumfile_changename' => $lcfilename2,
				'bnumfile_realname' => $filename2,
				'deposit_name' => $this->input->post('deposit_name'),
				'payment_account' => $this->input->post('payment_account'),
				'tax_part' => $this->input->post('tax_part'),
				'user_id' => $this->id,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		}

		if ($seq == null) {
			$result = $this->STC_Customer->customer_insert($data, $mode = 0);
			$mdata = $this->STC_Customer->customer_max_seq();
		} else {
			$result = $this->STC_Customer->customer_insert($data, $mode = 1, $seq);
		}

		if($seq == null && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_input2/".$mdata['seq']."'</script>";
		} else if($seq != null && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_view2/".$seq."'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}

	}

	//2. 거래처 담당자 입력/수정 처리
	function customer_input_action2() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post('seq');
		$mode = $this->input->post('mode');
		$person_array = $this->input->post('person_array');

		$data = array(
			'seq' => $seq,
			'person_array' => $person_array,
			'user_id' => $this->id
		 );

		if ($mode == 0) {
			$result = $this->STC_Customer->customer_insert2($data, $mode = 0);
		} else if ($mode == 1) {
			$result = $this->STC_Customer->customer_insert2($data, $mode = 1, $seq);
		}

		if($mode == 0 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_input3/".$seq."'</script>";
		} else if($mode == 1 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_view3/".$seq."'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	//3. 거래처 서비스(상품) 입력/수정 처리
	function customer_input_action3() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post('seq');
		$mode = $this->input->post('mode');
		$awards_experience = $this->input->post('awards_experience');
		$quality_flag = $this->input->post('quality_flag');
		$major_awards = $this->input->post('major_awards');
		$quality_certification = $this->input->post('quality_certification');
		$awards_count = $this->input->post('awards_count');

		$filename = NULL;
		$lcfilename = NULL;

		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);

		if ($csize > 0 && $cname) {
			if ($csize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//서비스(상품) 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/goods";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			$data = array(
				'customer_seq' => $seq,
				'awards_experience' => $awards_experience,
				'quality_flag' => $quality_flag,
				'major_awards' => $major_awards,
				'quality_certification' => $quality_certification,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'awards_count' => $awards_count,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		} else {
			$data = array(
				'customer_seq' => $seq,
				'awards_experience' => $awards_experience,
				'quality_flag' => $quality_flag,
				'major_awards' => $major_awards,
				'quality_certification' => $quality_certification,
				'awards_count' => $awards_count,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		}

		if ($mode == 0) {
			$result = $this->STC_Customer->customer_insert3($data, $mode = 0);
		} else if ($mode == 1) {
			$result = $this->STC_Customer->customer_insert3($data, $mode = 1, $seq);
		}

		if($mode == 0 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_input4/".$seq."'</script>";
		} else if($mode == 1 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_view4/".$seq."'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	//4. 거래처 서비스(용역-서비스제공정보) 입력/수정 처리
	function customer_input_action4() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post('seq');
		$mode = $this->input->post('mode');
		$service_array = $this->input->post('service_array');
		$project_array = $this->input->post('project_array');
		$homepage = $this->input->post('homepage');

		$data = array(
			'seq' => $seq,
			'service_array' => $service_array,
			'project_array' => $project_array,
			'homepage' => $homepage
		 );

		if ($mode == 0) {
			$result = $this->STC_Customer->customer_insert4($data, $mode = 0);
		} else if ($mode == 1) {
			$result = $this->STC_Customer->customer_insert4($data, $mode = 1, $seq);
		}

		if($mode == 0 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_input5/".$seq."'</script>";
		} else if($mode == 1 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_view5/".$seq."'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	//5. 거래처 재무정보 입력/수정 처리
	function customer_input_action5() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post('seq');
		$mode = $this->input->post('mode');

		//가져온 내용 시작
		$filename = NULL;
		$lcfilename = NULL;
		$filename2 = NULL;
		$lcfilename2 = NULL;
		$filename3 = NULL;
		$lcfilename3 = NULL;
		$filename4 = NULL;
		$lcfilename4 = NULL;
		$filename5 = NULL;
		$lcfilename5 = NULL;

		$bsize = $_FILES["bfile"]["size"];
		$bname = $_FILES["bfile"]["name"];
		$ext = substr(strrchr($bname,"."),1);
		$ext = strtolower($ext);

		$bsize2 = $_FILES["bfile2"]["size"];
		$bname2 = $_FILES["bfile2"]["name"];
		$ext2 = substr(strrchr($bname2,"."),1);
		$ext2 = strtolower($ext2);

		$dsize = $_FILES["dfile"]["size"];
		$dname = $_FILES["dfile"]["name"];
		$ext3 = substr(strrchr($dname,"."),1);
		$ext3 = strtolower($ext3);

		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext4 = substr(strrchr($cname,"."),1);
		$ext4 = strtolower($ext4);

		$gsize = $_FILES["gfile"]["size"];
		$gname = $_FILES["gfile"]["name"];
		$ext5 = substr(strrchr($gname,"."),1);
		$ext5 = strtolower($ext5);

//		echo "bsize::".$bsize."<br>";
//		echo "bsize2::".$bsize2."<br>";
//		echo "dsize::".$dsize."<br>";
//		echo "csize::".$csize."<br>";
//		echo "gsize::".$gsize."<br>";
//		exit;

		if (($bsize > 0 && $bname) && ($bsize2 > 0 && $bname2)) {
			if ($bsize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}
			if ($bsize2 > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
			if($ext2 != "doc" && $ext2 != "docx" && $ext2 != "txt" && $ext2 != "ppt" && $ext2 != "pptx" && $ext2 != "xls" && $ext2 != "xlsx" && $ext2 != "zip" && $ext2 != "rar" && $ext2 != "gif" && $ext2 != "jpg" && $ext2 != "jpeg" && $ext2 != "png" && $ext2 != "pdf" && $ext2 != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//전기 재무정보 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/finance";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('bfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			//전전기 재무정보 업로드
			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('bfile2') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename2 = $data['upload_data']['orig_name'];
				$lcfilename2 = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			// 1,2,3
			if(($dsize > 0) && ($csize > 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,2
			else if(($dsize > 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2,3
			else if(($dsize <= 0) && ($csize > 0) && ($gsize > 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,3
			else if(($dsize > 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1
			else if(($dsize > 0) && ($csize <= 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2
			else if(($dsize <= 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//3
			else if(($dsize <= 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			// 없음
			else {
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
		} else if (($bsize > 0 && $bname) && ($bsize2 <= 0 )) {
			if ($bsize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//전기재무정보 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/finance";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('bfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			// 1,2,3
			if(($dsize > 0) && ($csize > 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,2
			else if(($dsize > 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2,3
			else if(($dsize <= 0) && ($csize > 0) && ($gsize > 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,3
			else if(($dsize > 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1
			else if(($dsize > 0) && ($csize <= 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2
			else if(($dsize <= 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//3
			else if(($dsize <= 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			// 없음
			else {
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'bfile_changename' => $lcfilename,
					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'bfile_changename2' =>  $lcfilename2,
//					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
		} else if (($bsize2 > 0 && $bname2) && ($bsize <= 0 )) {
			if ($bsize2 > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext2 != "doc" && $ext2 != "docx" && $ext2 != "txt" && $ext2 != "ppt" && $ext2 != "pptx" && $ext2 != "xls" && $ext2 != "xlsx" && $ext2 != "zip" && $ext2 != "rar" && $ext2 != "gif" && $ext2 != "jpg" && $ext2 != "jpeg" && $ext2 != "png" && $ext2 != "pdf" && $ext2 != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//전전기 재무정보 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/finance";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('bfile2') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename2 = $data['upload_data']['orig_name'];
				$lcfilename2 = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			// 1,2,3
			if(($dsize > 0) && ($csize > 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,2
			else if(($dsize > 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2,3
			else if(($dsize <= 0) && ($csize > 0) && ($gsize > 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,3
			else if(($dsize > 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1
			else if(($dsize > 0) && ($csize <= 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2
			else if(($dsize <= 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//3
			else if(($dsize <= 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			// 없음
			else {
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
//					'bfile_changename' => $lcfilename,
//					'bfile_realname' => $filename,
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'bfile_changename2' =>  $lcfilename2,
					'bfile_realname2' =>  $filename2,
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
		} else {
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/finance";
			// 1,2,3
			if(($dsize > 0) && ($csize > 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,2
			else if(($dsize > 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2,3
			else if(($dsize <= 0) && ($csize > 0) && ($gsize > 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1,3
			else if(($dsize > 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//1
			else if(($dsize > 0) && ($csize <= 0) && ($gsize <= 0)) {
				if ($dsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext3 != "doc" && $ext3 != "docx" && $ext3 != "txt" && $ext3 != "ppt" && $ext3 != "pptx" && $ext3 != "xls" && $ext3 != "xlsx" && $ext3 != "zip" && $ext3 != "rar" && $ext3 != "gif" && $ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//기본정보 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('dfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename3 = $data['upload_data']['orig_name'];
					$lcfilename3 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
					'dfile_changename' =>  $lcfilename3,
					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//2
			else if(($dsize <= 0) && ($csize > 0) && ($gsize <= 0)) {
				if ($csize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext4 != "doc" && $ext4 != "docx" && $ext4 != "txt" && $ext4 != "ppt" && $ext4 != "pptx" && $ext4 != "xls" && $ext4 != "xlsx" && $ext4 != "zip" && $ext4 != "rar" && $ext4 != "gif" && $ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//국세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('cfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename4 = $data['upload_data']['orig_name'];
					$lcfilename4 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}

				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
					'cfile_changename' =>  $lcfilename4,
					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			//3
			else if(($dsize <= 0) && ($csize <= 0) && ($gsize > 0)) {
				if ($gsize > 209715200) {
					echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
					exit;
				}
				if($ext5 != "doc" && $ext5 != "docx" && $ext5 != "txt" && $ext5 != "ppt" && $ext5 != "pptx" && $ext5 != "xls" && $ext5 != "xlsx" && $ext5 != "zip" && $ext5 != "rar" && $ext5 != "gif" && $ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "hwp") {
					echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
					exit;
				}
				//지방세 납세증명서 업로드
				$conf_file['upload_path'] = $upload_dir;
				$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
				$conf_file['overwrite']  = false;
				$conf_file['encrypt_name']  = true;
				$conf_file['remove_spaces']  = true;

				$this->load->library( 'upload', $conf_file );

				if( $this->upload->do_upload('gfile') ) {
					$data = array('upload_data' => $this->upload->data());
					$filename5 = $data['upload_data']['orig_name'];
					$lcfilename5 = $data['upload_data']['file_name'];
				} else {
					alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
					exit;
				}
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
					'gfile_changename' =>  $lcfilename5,
					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
			// 없음
			else {
				$data = array(
					'customer_seq' => $seq,
					'closing_year' => $this->input->post('closing_year'),
					'total_asset' => $this->input->post('total_asset'),
					'sales_amount' => $this->input->post('sales_amount'),
					'capital' => $this->input->post('capital'),
					'profit' => $this->input->post('profit'),
					'working_capital' => $this->input->post('working_capital'),
					'working_ratio' => $this->input->post('working_ratio'),
					'closing_year2' => $this->input->post('closing_year2'),
					'total_asset2' => $this->input->post('total_asset2'),
					'sales_amount2' => $this->input->post('sales_amount2'),
					'capital2' => $this->input->post('capital2'),
					'profit2' => $this->input->post('profit2'),
					'working_capital2' => $this->input->post('working_capital2'),
					'working_ratio2' => $this->input->post('working_ratio2'),
//					'dfile_changename' =>  $lcfilename3,
//					'dfile_realname' =>  $filename3,
					'ccert_date' => $this->input->post('ccert_date'),
//					'cfile_changename' =>  $lcfilename4,
//					'cfile_realname' =>  $filename4,
					'gcert_date' => $this->input->post('gcert_date'),
//					'gfile_changename' =>  $lcfilename5,
//					'gfile_realname' =>  $filename5,
					'insert_date' => date("Y-m-d H:i:s"),
					'update_date' => date("Y-m-d H:i:s")
				);
			}
		}
		//가져온 내용 끝

		if ($mode == 0) {
			$result = $this->STC_Customer->customer_insert5($data, $mode = 0);
		} else if ($mode == 1) {
			$result = $this->STC_Customer->customer_insert5($data, $mode = 1, $seq);
		}

		if($mode == 0 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_input6/".$seq."'</script>";
		} else if($mode == 1 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_view6/".$seq."'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	//6. 거래처 신용정보 입력/수정 처리
	function customer_input_action6() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post('seq');
		$mode = $this->input->post('mode');

		$eval_company = $this->input->post('eval_company');
		$rate = $this->input->post('rate');
		$eval_date = $this->input->post('eval_date');
		$early_date = $this->input->post('early_date');

		$filename = NULL;
		$lcfilename = NULL;

		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);

		if ($csize > 0 && $cname) {
			if ($csize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//신용정보 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/credit";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			$data = array(
				'customer_seq' => $seq,
				'eval_company' => $eval_company,
				'rate' => $rate,
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'eval_date' => $eval_date,
				'early_date' => $early_date,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		} else {
			$data = array(
				'customer_seq' => $seq,
				'eval_company' => $eval_company,
				'rate' => $rate,
				'eval_date' => $eval_date,
				'early_date' => $early_date,
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			);
		}

		if ($mode == 0) {
			$result = $this->STC_Customer->customer_insert6($data, $mode = 0);
		} else if ($mode == 1) {
			$result = $this->STC_Customer->customer_insert6($data, $mode = 1, $seq);
		}

		if($mode == 0 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_list'</script>";
		} else if($mode == 1 && $result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/customer_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}
	}

	// 1-1. 거래처 기본정보(사업자등록증) 첨부파일 다운로드처리
	function customer_download($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file($seq, $filelcname);

		if (!isset($fdata['cnumfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/basic/".$fdata['cnumfile_changename']);

		if (!force_download(urlencode($fdata['cnumfile_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 1-2. 거래처 기본정보(계좌번호) 첨부파일 다운로드처리
	function customer_download2($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file2($seq, $filelcname);

		if (!isset($fdata['bnumfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/basic/".$fdata['bnumfile_changename']);

		if (!force_download(urlencode($fdata['bnumfile_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 3. 거래처 서비스(상품) 첨부파일 다운로드처리
	function customer_download3($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file3($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/goods/".$fdata['file_changename']);

		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 4. 거래처 서비스(소싱그룹) 첨부파일 다운로드처리
	function customer_download4($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file4($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/goods/".$fdata['file_changename']);

		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 5-1. 거래처 전기 재무정보 첨부파일 다운로드처리
	function customer_download5($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file5($seq, $filelcname);

		if (!isset($fdata['bfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['bfile_changename']);

		if (!force_download(urlencode($fdata['bfile_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 5-2. 거래처 전전기 재무정보 첨부파일 다운로드처리
	function customer_download6($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file6($seq, $filelcname);

		if (!isset($fdata['bfile_changename2'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['bfile_changename2']);

		if (!force_download(urlencode($fdata['bfile_realname2']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 5-3. 거래처 기본정보 첨부파일 다운로드처리
	function customer_download7($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file7($seq, $filelcname);

		if (!isset($fdata['dfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['dfile_changename']);

		if (!force_download(urlencode($fdata['dfile_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 5-4. 거래처 국세 첨부파일 다운로드처리
	function customer_download8($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file8($seq, $filelcname);

		if (!isset($fdata['cfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['cfile_changename']);

		if (!force_download(urlencode($fdata['cfile_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 5-5. 거래처 지방세 첨부파일 다운로드처리
	function customer_download9($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file9($seq, $filelcname);

		if (!isset($fdata['gfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['gfile_changename']);

		if (!force_download(urlencode($fdata['gfile_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 6. 거래처 신용정보 첨부파일 다운로드처리
	function customer_download10($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file10($seq, $filelcname);

		if (!isset($fdata['file_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		}

		$data = file_get_contents("/var/www/html/stc/misc/upload/admin/customer/credit/".$fdata['file_changename']);

		if (!force_download(urlencode($fdata['file_realname']), $data)) {
			alert('파일을 찾을 수 없습니다.');
		}
	}

	// 5-1 거래처 전기재무정보 첨부파일 삭제처리
	function customer_filedel($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file5($seq, $filelcname);

		if (!isset($fdata['bfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Customer->customer_filedel5($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['bfile_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/customer/customer_view5/'.$seq);
		}
	}

	// 5-2 거래처 전전기재무정보 첨부파일 삭제처리
	function customer_filedel2($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file6($seq, $filelcname);

		if (!isset($fdata['bfile_changename2'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Customer->customer_filedel6($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['bfile_changename2']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/customer/customer_view5/'.$seq);
		}
	}

	// 5-3 거래처 기본정보 첨부파일 삭제처리
	function customer_filedel3($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file7($seq, $filelcname);

		if (!isset($fdata['dfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Customer->customer_filedel7($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['dfile_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/customer/customer_view5/'.$seq);
		}
	}

	// 5-4 거래처 국세 첨부파일 삭제처리
	function customer_filedel4($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file8($seq, $filelcname);

		if (!isset($fdata['cfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Customer->customer_filedel8($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['cfile_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/customer/customer_view5/'.$seq);
		}
	}

	// 5-5 거래처 지방세 첨부파일 삭제처리
	function customer_filedel5($seq, $filelcname) {
		$this->load->helper('alert');
		$this->load->helper('download');
		// $this->load->Model('STC_Customer');

		$fdata = $this->STC_Customer->customer_file9($seq, $filelcname);

		if (!isset($fdata['gfile_changename'])) {
			alert("파일 정보가 존재하지 않습니다.");
		} else {
			$fdata2 = $this->STC_Customer->customer_filedel9($seq);
			if($fdata2) {
				unlink("/var/www/html/stc/misc/upload/admin/customer/finance/".$fdata['gfile_changename']);
			}
			alert('파일이 정상적으로 삭제되었습니다.', site_url().'/sales/customer/customer_view5/'.$seq);
		}
	}

	// 1. 거래처 기본 쓰기 뷰
	function customer_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$this->load->view( 'sales/customer_input');
	}

	// 2. 거래처 담당자쓰기 뷰
	function customer_input2($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['seq'] = $seq;
		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$this->load->view( 'sales/customer_input2' , $data);
	}

	// 3. 거래처 서비스(상품)쓰기 뷰
	function customer_input3($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$data['seq'] = $seq;

		//소싱그룹 리스트 시작
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		$no_page_list = 3;										//	한페이지에 나타나는 목록 개수

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		}
		else {
			$search_keyword = "";
		}

		$search1 = "";

		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		}
		else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search2'] = $search2;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Customer->sourcing_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Customer->sourcing_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

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

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;
		//소싱그룹 리스트 끝

		$this->load->view( 'sales/customer_input3' , $data);
	}

	// 4. 거래처 서비스(용역)쓰기 뷰
	function customer_input4($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['seq'] = $seq;
		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$this->load->view( 'sales/customer_input4' , $data);
	}

	// 5. 거래처 재무정보 쓰기 뷰
	function customer_input5($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['seq'] = $seq;
		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$this->load->view( 'sales/customer_input5' , $data);
	}

	// 6. 거래처 신용정보 쓰기 뷰
	function customer_input6($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$data['seq'] = $seq;
		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$this->load->view( 'sales/customer_input6' , $data);
	}

	// 1. 거래처 기본사항 보기/수정 뷰
	function customer_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$mode = $this->input->get( 'mode' );

		// 로그인한 사람의 사업자번호 넘겨서 seq가져오기
		$getseq = $this->STC_Customer->customer_getseq($this->cnum);
		$seq = $getseq['seq'];

		if(!$seq) {
			echo "<script>alert('등록된 거래처가 없습니다.');history.go(-1);</script>";
			exit;
		}

		// 로그인한 사람의 seq와 등록된 seq 비교체크
		$strCheck = $this->STC_Customer->customer_view_check($seq);
		if($this->cnum != $strCheck['cnum']) {
			echo "<script>alert('등록된 거래처가 없거나 잘못된 경로로 접근하였습니다.');history.go(-1);</script>";
			exit;
		}

		$data['view_val'] = $this->STC_Customer->customer_view($seq);
		$data['seq'] = $seq;

		$this->load->view( 'sales/customer_modify', $data );
	}

	// 2. 거래처 담당자 보기/수정 뷰
	function customer_view2($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$mode = $this->input->post( 'mode' );

		$strCheck = $this->STC_Customer->customer_view_check($seq);
		// 로그인한 사람의 seq와 등록된 seq 비교체크
		if($this->cnum != $strCheck['cnum']) {
			echo "<script>alert('잘못된 경로로 접근하였습니다.');history.go(-1);</script>";
			exit;
		}

		$strResult = $this->STC_Customer->customer_view2($seq);
		// 거래처 담당자가 없을경우 입력페이지로 이동
		if($strResult == false) {
			echo "<script>alert('정상적으로 데이터를 가져오지 못했습니다.');history.go(-1);</script>";
			exit;
		}

		$data['view_val'] = $strResult;

		$data['seq'] = $seq;

		$this->load->view( 'sales/customer_modify2', $data );
	}

	// 3. 거래처 서비스(상품) 보기/수정 뷰
	function customer_view3($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$mode = $this->input->post( 'mode' );
		$strCheck = $this->STC_Customer->customer_view_check($seq);
		// 로그인한 사람의 seq와 등록된 seq 비교체크
		if($this->cnum != $strCheck['cnum']) {
			echo "<script>alert('잘못된 경로로 접근하였습니다.');history.go(-1);</script>";
			exit;
		}

		$strResult = $this->STC_Customer->customer_view3($seq);

		// 거래처 서비스(상품)이 없을경우 입력페이지로 이동
		if($strResult == false) {
			echo "<script>alert('정상적으로 데이터를 가져오지 못했습니다.');history.go(-1);</script>";
			exit;
		}

		$data['view_val'] = $strResult;
		$data['seq'] = $seq;

		//소싱그룹 리스트 시작
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		$no_page_list = 3;										//	한페이지에 나타나는 목록 개수

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		}
		else {
			$search_keyword = "";
		}

		$search1 = "";

		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		}
		else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search2'] = $search2;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Customer->sourcing_list2($search_keyword, $search1, $search2);
		$data['count'] = $this->STC_Customer->sourcing_list_count2($search_keyword, $search1, $search2)->ucount;
//		$user_list_data = $this->STC_Customer->sourcing_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
//		$data['count'] = $this->STC_Customer->sourcing_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

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

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;
		//소싱그룹 리스트 끝

		$this->load->view( 'sales/customer_modify3', $data );
	}

	// 4. 거래처 서비스(용역) 보기/수정 뷰
	function customer_view4($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$mode = $this->input->post( 'mode' );
		$strCheck = $this->STC_Customer->customer_view_check($seq);
		// 로그인한 사람의 seq와 등록된 seq 비교체크
		if($this->cnum != $strCheck['cnum']) {
			echo "<script>alert('잘못된 경로로 접근하였습니다.');history.go(-1);</script>";
			exit;
		}

		$strSupply = $this->STC_Customer->customer_view4($seq);
		$strRecord = $this->STC_Customer->customer_view5($seq);
		$strEtc = $this->STC_Customer->customer_view6($seq);

		// 거래처 서비스(상품)이 없을경우 입력페이지로 이동
		if($strSupply == false) {
			echo "<script>alert('정상적으로 데이터를 가져오지 못했습니다.');history.go(-1);</script>";
			exit;
		}

		$data['view_val'] = $strSupply;
		$data['view_val2'] = $strRecord;
		$data['view_val3'] = $strEtc;
		$data['seq'] = $seq;

		$this->load->view( 'sales/customer_modify4', $data );
	}

	// 5. 거래처 재무정보 보기/수정 뷰
	function customer_view5($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$mode = $this->input->post( 'mode' );
		$strCheck = $this->STC_Customer->customer_view_check($seq);
		// 로그인한 사람의 seq와 등록된 seq 비교체크
		if($this->cnum != $strCheck['cnum']) {
			echo "<script>alert('잘못된 경로로 접근하였습니다.');history.go(-1);</script>";
			exit;
		}

		$strResult = $this->STC_Customer->customer_view7($seq);

		// 거래처 재무정보가 없을경우 입력페이지로 이동
		if($strResult == false) {
			echo "<script>alert('정상적으로 데이터를 가져오지 못했습니다.');history.go(-1);</script>";
			exit;
		}

		$data['view_val'] = $strResult;
		$data['seq'] = $seq;

		$this->load->view( 'sales/customer_modify5', $data );
	}

	// 6. 거래처 신용정보 보기/수정 뷰
	function customer_view6($seq) {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$mode = $this->input->post( 'mode' );
		$strCheck = $this->STC_Customer->customer_view_check($seq);
		// 로그인한 사람의 seq와 등록된 seq 비교체크
		if($this->cnum != $strCheck['cnum']) {
			echo "<script>alert('잘못된 경로로 접근하였습니다.');history.go(-1);</script>";
			exit;
		}

		$strResult = $this->STC_Customer->customer_view8($seq);

		// 거래처 재무정보가 없을경우 입력페이지로 이동
		if($strResult == false) {
			echo "<script>alert('정상적으로 데이터를 가져오지 못했습니다.');history.go(-1);</script>";
			exit;
		}

		$data['view_val'] = $strResult;
		$data['seq'] = $seq;

		$this->load->view( 'sales/customer_modify6', $data );
	}

	// 거래처 삭제
	function customer_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Customer->customer_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/sales/customer/customer_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}

	//SourcingGroup 리스트(공통)
	function sourcing_list() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
//		$cur_page = $this->input->get( 'cur_page' );			//	현재 페이지
		if(isset($_GET['cur_page'])) {
			$cur_page = $_GET['cur_page'];
		}
		else {
			$cur_page = 0;
		}														//	현재 페이지
		$no_page_list = 10;										//	한페이지에 나타나는 목록 개수

		if(isset($_GET['searchkeyword'])) {
			$search_keyword = $_GET['searchkeyword'];
		}
		else {
			$search_keyword = "";
		}


		$search1 = "";

		if(isset($_GET['search2'])) {
			$search2 = $_GET['search2'];
		}
		else {
			$search2 = "";
		}

		$data['search_keyword'] = $search_keyword;
		$data['search2'] = $search2;

		if  ( $cur_page <= 0 )
			$cur_page = 1;

		$data['cur_page'] = $cur_page;

		$user_list_data = $this->STC_Customer->sourcing_list($search_keyword, $search1, $search2, ( $cur_page - 1 ) * $no_page_list, $no_page_list);
		$data['count'] = $this->STC_Customer->sourcing_list_count($search_keyword, $search1, $search2)->ucount;

		$data['list_val'] = $user_list_data['data'];
		$data['list_val_count'] = $user_list_data['count'];

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

		$data['category'] = $this->STC_Common->get_category();

		$data['no_page_list'] = $no_page_list;
		$data['total_page'] = $total_page;
		$data['start_page'] = $start_page;
		$data['end_page'] = $end_page;

		$this->load->view( 'sales/sourcing_list', $data );
	}

	//SourcingGroup 입력/수정 처리
	function sourcing_input_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post('seq');

		$filename = NULL;
		$lcfilename = NULL;

		$csize = $_FILES["cfile"]["size"];
		$cname = $_FILES["cfile"]["name"];
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);

		if ($csize > 0 && $cname) {
			if ($csize > 209715200) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n200MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>";
				exit;
			}

			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}

			//서비스(상품) 업로드
			$upload_dir = "/var/www/html/stc/misc/upload/admin/customer/goods";

			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;

			$this->load->library( 'upload', $conf_file );

			if( $this->upload->do_upload('cfile') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
			} else {
				alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.');
				exit;
			}

			$data = array(
				'part' => $this->input->post('part'),
				'solution_group' => $this->input->post('solution_group'),
				'product_company' => $this->input->post('product_company'),
				'product_capacity' => $this->input->post('product_capacity'),
				'ecount' => $this->input->post('ecount'),
				'dcount' => $this->input->post('dcount'),
				'dprice' => $this->input->post('dprice'),
				'file_changename' => $lcfilename,
				'file_realname' => $filename,
				'manage' => $this->input->post('manage'),
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		} else {
			$data = array(
				'part' => $this->input->post('part'),
				'solution_group' => $this->input->post('solution_group'),
				'product_company' => $this->input->post('product_company'),
				'product_capacity' => $this->input->post('product_capacity'),
				'ecount' => $this->input->post('ecount'),
				'dcount' => $this->input->post('dcount'),
				'dprice' => $this->input->post('dprice'),
				'manage' => $this->input->post('manage'),
				'insert_date' => date("Y-m-d H:i:s"),
				'update_date' => date("Y-m-d H:i:s")
			 );
		}

		if ($seq == null) {
			$result = $this->STC_Customer->sourcing_insert($data, $mode = 0);
		} else {
			$result = $this->STC_Customer->sourcing_insert($data, $mode = 1, $seq);
		}

		if($result) {
			echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/customer/sourcing_list'</script>";
		} else {
			echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
		}

	}

	// SourcingGroup 쓰기 뷰
	function sourcing_input() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
		$this->load->view( 'sales/sourcing_input', $data );
	}

	// SourcingGroup 보기/수정 뷰
	function sourcing_view() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		// $this->load->Model(array('STC_Customer', 'STC_Common'));
		$data['category'] = $this->STC_Common->get_category();
//		$user_id = $this->idx;

		$seq = $this->input->get( 'seq' );
		$mode = $this->input->get( 'mode' );

		$data['view_val'] = $this->STC_Customer->sourcing_view($seq);
		$data['seq'] = $seq;

		$this->load->view( 'sales/sourcing_modify', $data );
	}

	// SourcingGroup 삭제
	function sourcing_delete_action() {
		if( $this->id === null ) {
			redirect( 'account' );
		}

		$this->load->helper('alert');
		// $this->load->Model( 'STC_Customer' );
		$seq = $this->input->post( 'seq' );

		if ($seq != null) {
			$tdata = $this->STC_Customer->sourcing_delete($seq);
		}

		if ($tdata) {
			echo "<script>alert('삭제완료 되었습니다.');location.href='".site_url()."/sales/customer/sourcing_list'</script>";
		} else {
			alert("정상적으로 처리되지 못했습니다.\n다시 시도해 주세요.");
		}
	}
}
?>
