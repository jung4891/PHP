<?php
header("Content-type: text/html; charset=utf-8");

class Ajax extends CI_Controller
{
	var $id = '';

	function __construct()
	{
		parent::__construct();
		$this->id = $this->phpsession->get('id', 'stc');
		$this->name = $this->phpsession->get( 'name', 'stc' );
	}

	function index()
	{
		redirect('');
	}

	// 아이디체크
	function idcheck()
	{
		$uid = $this->input->post('id');

		if ($uid == null) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User', 'STC_Common'));
			$result = $this->STC_User->idcheck($uid);

			if ($result == false) {
				$arr = array('result' => 'false');
				echo json_encode($arr);
			} else {
				$arr = array('result' => 'true');
				echo json_encode($arr);
			}
		}
	}

	// wakeup
	function wakeup()
	{
		$this->load->model('WF_Command');
		$hp_ip = $this->input->post('hp_ip');
		$hp_no = $this->input->post('hp_no');
		$mc_ip = $this->input->post('mip');

		$return_flag = $this->WF_Command->csocket(8, $hp_ip, $hp_no, $mc_ip);
		$arr = array('socket_result' => $return_flag);
		echo json_encode($arr);
	}

	//subproject seq가져오기
	function subProjectAdd()
	{
		$subProjectSeq = $this->input->post('subProjectSeq');

		if ($subProjectSeq == null) {
			redirect('');
		} else {
			$this->load->Model(array('STC_Maintain', 'STC_Common'));
			$result = $this->STC_Maintain->subProjectAdd($subProjectSeq);
			echo json_encode($result);
		}
	}

	//연계 프로젝트 sub_project_add update문
	function sub_project_add_update(){
		$subProjectSeq = $this->input->post('subProjectSeq');
		$seq = $this->input->post('seq');

		if ($subProjectSeq == null or $seq == null) {
			redirect('');
		} else {
			$this->load->Model(array('STC_Maintain', 'STC_Common'));
			$result = $this->STC_Maintain->sub_project_add_update($seq, $subProjectSeq);
			echo json_encode($result);
		}
	}

	//연계 프로젝트 sub_project_remove update문
	function sub_project_remove_update()
	{
		$seq = $this->input->post('seq');
		$parent_seq = $this->input->post('parent_seq');
		if ($seq == null) {
			redirect('');
		} else {
			$this->load->Model(array('STC_Maintain', 'STC_Common'));
			$result = $this->STC_Maintain->sub_project_remove_update($seq,$parent_seq);
			echo json_encode($result);
		}
	}

	//거래처 사람들 데려오기
	function sales_customer_staff(){
		$seq = $this->input->post('seq');

		if ($seq == null) {
			redirect('');
		} else {
			$this->load->Model(array('STC_User'));
			$result = $this->STC_User->sales_customer_staff($seq);
			echo json_encode($result);
		}
	}

	//제품 검색
	function product_search(){
		$product_company = $this->input->post('productCompany');
		$product_type = $this->input->post('productType');

		$this->load->Model(array('STC_Common'));
		$result = $this->STC_Common->get_product($product_company,$product_type);
		echo json_encode($result);	
	}

	//수주 정보 코멘트 파일업로드
	function forcasting_complete_status_file_upload(){
		$filename = NULL;
		$lcfilename = NULL;

		$csize = $_FILES['file']["size"];
		$cname = $_FILES['file']["name"];
		 
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);
   
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
	
			$upload_dir = "/var/www/html/stc/misc/upload/sales/complete_status_comment";
	
			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;
	
			$this->load->library( 'upload', $conf_file );
	
			if( $this->upload->do_upload('file') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
				$arr = array('file_real_name' => $filename,'file_change_name' => $lcfilename );
				echo json_encode($arr);
			} else {
				echo json_encode("false");
				exit;
			}
		}
	}

	//유지보수 수주 정보 코멘트 파일업로드
	function maintain_complete_status_file_upload(){
		$filename = NULL;
		$lcfilename = NULL;

		$csize = $_FILES['file']["size"];
		$cname = $_FILES['file']["name"];
			
		$ext = substr(strrchr($cname,"."),1);
		$ext = strtolower($ext);
	
		if ($csize > 0 && $cname) {
			if ($csize > 104857600) {
				echo "<script>alert('첨부파일의 용량이 초과하였습니다.\\n100MB 이하의 파일을 첨부해주세요.');history.go(-1);</script>"; /* 김수성 수정 2017-01-06 */
				exit;
			}
			if($ext != "doc" && $ext != "docx" && $ext != "txt" && $ext != "ppt" && $ext != "pptx" && $ext != "xls" && $ext != "xlsx" && $ext != "zip" && $ext != "rar" && $ext != "gif" && $ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "hwp") {
				echo "<script>alert('이미지, 문서, 압축 파일만 올릴수 있습니다.');history.go(-1);</script>";
				exit;
			}
	
			$upload_dir = "/var/www/html/stc/misc/upload/sales/complete_status_comment";
	
			$conf_file['upload_path'] = $upload_dir;
			$conf_file['allowed_types'] = 'zip|rar|txt|doc|pdf|ppt|xls|pptx|docx|xlsx|gif|jpg|png|hwp|jpeg';
			$conf_file['overwrite']  = false;
			$conf_file['encrypt_name']  = true;
			$conf_file['remove_spaces']  = true;
	
			$this->load->library( 'upload', $conf_file );
	
			if( $this->upload->do_upload('file') ) {
				$data = array('upload_data' => $this->upload->data());
				$filename = $data['upload_data']['orig_name'];
				$lcfilename = $data['upload_data']['file_name'];
				$arr = array('file_real_name' => $filename,'file_change_name' => $lcfilename );
				echo json_encode($arr);
			} else {
				echo json_encode("false");
				exit;
			}
		}
	}

	//수주 정보 코멘트 insert
	function forcasting_complete_status_comment_insert(){
		$forcasting_seq = $this->input->post('seq');
		$user_id = $this->id;
		$user_name = $this->name;
		$complete_status = $this->input->post('status');
		$contents = $this->input->post('contents');
		$file_change_name = $this->input->post('file_change_name');
		$file_real_name = $this->input->post('file_real_name');
	
		$data = array(
			'forcasting_seq' => $forcasting_seq,
			'user_id' => $user_id,
			'user_name' => $user_name,
			'complete_status' => $complete_status,
			'contents' => $contents,
			'file_change_name' => $file_change_name,
			'file_real_name' => $file_real_name,
			'insert_date' =>date("Y-m-d H:i:s")
		);

		$this->load->Model(array('STC_Forcasting'));
		$result = $this->STC_Forcasting->forcasting_complete_status_comment_insert($data);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

	//유지보수 수주 정보 코멘트 insert
	function maintain_complete_status_comment_insert(){
		$maintain_seq = $this->input->post('seq');
		$user_id = $this->id;
		$user_name = $this->name;
		$complete_status = $this->input->post('status');
		$contents = $this->input->post('contents');
		$file_change_name = $this->input->post('file_change_name');
		$file_real_name = $this->input->post('file_real_name');
	
		$data = array(
			'maintain_seq' => $maintain_seq,
			'user_id' => $user_id,
			'user_name' => $user_name,
			'complete_status' => $complete_status,
			'contents' => $contents,
			'file_change_name' => $file_change_name,
			'file_real_name' => $file_real_name,
			'insert_date' =>date("Y-m-d H:i:s")
		);

		$this->load->Model(array('STC_Maintain'));
		$result = $this->STC_Maintain->maintain_complete_status_comment_insert($data);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

	//수주 정보 코멘트 delete
	function forcasting_complete_status_comment_delete(){
		$seq = $this->input->post('seq');
		$this->load->Model(array('STC_Forcasting'));
		$result = $this->STC_Forcasting->forcasting_complete_status_comment_delete($seq);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

	//수주 정보 코멘트 delete
	function maintain_complete_status_comment_delete(){
		$seq = $this->input->post('seq');
		$this->load->Model(array('STC_Maintain'));
		$result = $this->STC_Maintain->maintain_complete_status_comment_delete($seq);
		if ($result == false) {
			$arr = array('result' => 'false');
			echo json_encode($arr);
		} else {
			$arr = array('result' => 'true');
			echo json_encode($arr);
		}
	}

	// 전자결재 양식 작성 결재정보 저장
	function approval_info_save(){
		$this->load->Model(array('STC_Approval'));

		$seq = $this->input->post('seq');
		$template_name = $this->input->post('template_name');
		$template_category = $this->input->post('template_category');
		$template_type = $this->input->post('template_type');
		$template_sort_seq = $this->input->post('template_sort_seq');
		$template_explanation = $this->input->post('template_explanation');
		$default_approval_line = $this->input->post('default_approval_line');
		$default_referrer = $this->input->post('default_referrer');
		
		if($seq == ""){
			$data = array(
				'template_name' => $template_name,
				'template_category' => $template_category,
				'template_type' => $template_type,
				'template_sort_seq' => $template_sort_seq,
				'template_explanation' => $template_explanation,
				'default_approval_line' => $default_approval_line,
				'default_referrer' => $default_referrer,
				'write_id' => $this->id,
				'insert_date' =>date("Y-m-d H:i:s")
			);
			$result = $this->STC_Approval->approval_info_save($data,'insert');
		}else{
			$data = array(
				'seq' => $seq,
				'template_name' => $template_name,
				'template_category' => $template_category,
				'template_type' => $template_type,
				'template_sort_seq' => $template_sort_seq,
				'template_explanation' => $template_explanation,
				'default_approval_line' => $default_approval_line,
				'default_referrer' => $default_referrer,
				'write_id' => $this->id,
				'insert_date' =>date("Y-m-d H:i:s")
			);
			$result = $this->STC_Approval->approval_info_save($data,'update');
		}
		echo json_encode($result);
	}

	//양식내용 저장
	function template_info_save(){
		$this->load->Model(array('STC_Approval'));
		$seq = $this->input->post('seq');
		$editor_use = $this->input->post('editor_use');
		$writing_guide = $this->input->post('writing_guide');
		$form_table_html = $this->input->post('form_table_html');
		$preview_html = $this->input->post('preview_html');

		$data = array(
			'editor_use' => $editor_use,
			'writing_guide' => $writing_guide,
			'form_table_html' => $form_table_html,
			'preview_html' => $preview_html,
			'write_id' => $this->id,
			'update_date' =>date("Y-m-d H:i:s")
		);

		$result = $this->STC_Approval->template_info_save($data,$seq);
		echo json_encode($result);
	}

	//조직도 그룹 별로 보기
	function groupView(){
		$group = $this->input->post('group');
		if( $group == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_Approval'));
			$result = $this->STC_Approval->groupView($group);
			echo json_encode($result);
		}
	}

	//상위그룹에 맞는 하위 그룹 보기
	function childGroup(){
		$parentGroup = $this->input->post('parentGroup');
		if( $parentGroup == null ) {
			redirect('');
		} else {
			$this->load->Model(array('STC_Approval'));
			$result = $this->STC_Approval->childGroup($parentGroup);
			echo json_encode($result);
		}
	}
	
	//부서 그룹 전체 가져오기
	function group(){
		$this->load->Model(array('STC_Approval'));
		$result = $this->STC_Approval->group();
		echo json_encode($result);
	}

}